<?php

namespace App\Services\Checkout;

use App\Models\Addresses;
use App\Models\GeneratedOrderId;
use App\Models\OrderLines;
use App\Models\Orders;
use App\Models\Products;
use App\Services\Cart\CartService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutService
{
    public const GEN_STATUS_CREATING = 'CREATING';
    public const GEN_STATUS_CREATED = 'CREATED';
    public const ORDER_STATUS_CREATED = 'ORDER_CREATED';

    /**
     * @param $param
     * @return array
     */
    public function creatOrder($param): array
    {
        try{
            $order_id = $this->getOrderId();
            if($order_id == "") {
                throw new Exception('get order_id fail', 400);
            }
            $insert_result = $this->insertOrderData($order_id, $param);
            if($insert_result['code'] == 200){
                $cart_service = new CartService();
                $result = $cart_service->deleteCart();
                if($result['code'] != 200){
                    throw new Exception($result['msg'], $result['code']);
                }
            }
            return $insert_result;
        } catch (Exception $exception) {
            Log::error('[CheckoutService][creatOrder] fail: ' . json_encode($exception->getMessage()));
            return responseFormat($exception->getCode(), $exception->getMessage());
        }

    }


    /**
     * insert addresses, order_lines, orders
     * update product inventory
     * @return array
     */
    public function insertOrderData($order_id, $param): array
    {
        DB::beginTransaction();
        try{
            Addresses::updateOrCreate(
                [
                    'order_id' => $order_id,
                    'type' => 'Shipping',
                ],
                [
                    'name' => $param['name'],
                    'address' => $param['address'],
                    'phone' => $param['phone'],
                    'email' => $param['email'],
                ]
            );
            Log::debug('[CheckoutService][insertOrderData] item: ' . json_encode($param['item']));
            $total_amount = 0.0;
            $order_line_number = 1;
            foreach($param['item']['data']['data'] as $item) {
                $inventory_qty = Products::select('qty')->where('sku', $item['sku'])->first();

                if($inventory_qty->qty < $item['quantity']) {
                    throw new Exception('Out of stock!', 400);
                }

                Products::where('sku', $item['sku'])->update(['qty' => ($inventory_qty->qty - $item['quantity'])]);

                OrderLines::updateOrCreate(
                    [
                        'order_id' => $order_id,
                        'order_line_number' => $order_line_number,
                    ],
                    [
                        'sku' => $item['sku'],
                        'net_price' => $item['price'],
                        'line_total' => $item['price'] * $item['quantity'],
                        'qty' => $item['quantity'],
                    ]);
                $total_amount += $item['price'] * $item['quantity'];
                $order_line_number++;
            }

            Orders::updateOrCreate(
                [
                    'order_id' => $order_id,
                ],
                [
                    'status' => self::ORDER_STATUS_CREATED,
                    'total_price' => $total_amount,
                    'user_id' => 1,
                ]);

            GeneratedOrderId::where('order_id', $order_id)->update(
                ['status' => self::GEN_STATUS_CREATED]);

            DB::commit();
            return responseFormat(200, 'success');
        } catch(Exception $exception) {
            Log::debug('[CheckoutService][insertOrderData] fail: ' . json_encode($exception->getMessage()));
            DB::rollback();
            return responseFormat($exception->getCode(), $exception->getMessage());
        }

    }

    /**
     * generated order_id
     * @return string
     */
    public function getOrderId(): string
    {
        try{
            $order_id = '';
            $count = 0;
            do {
                $count++;
                $microtime = substr((string) microtime(), 1, 8);
                $ounded = round($microtime, 3);
                $order_no = date('YmdHis').substr((string) $ounded, 2, strlen($ounded));

                $generated_order = GeneratedOrderId::firstOrCreate(
                    [
                        'order_id' => $order_no,
                        'status' => self::GEN_STATUS_CREATING,
                    ]
                );
                if($generated_order->wasRecentlyCreated === true) {
                    $order_id = $generated_order->order_id;
                    Log::debug('[CheckoutService][getOrderId] wasRecentlyCreated: ' . json_encode($generated_order->toArray()));
                } else {
                    Log::debug('[CheckoutService][getOrderId] not wasRecentlyCreated: ' . json_encode($generated_order->toArray()));
                }

            } while ($order_id == '' || $count == 10);

            return $order_id;
        } catch (Exception $exception) {
            Log::error('[CheckoutService][getOrderId] fail: ' . $exception->getCode(). ', msg:' . $exception->getMessage());
            return "";
        }
    }
}

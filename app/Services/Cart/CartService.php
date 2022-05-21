<?php

namespace App\Services\Cart;

use App\Models\Products;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartService
{
    private $cart_item;
    public function __construct()
    {
        if(is_null($this->cart_item)) {
            Log::debug('['.__METHOD__.'] null cart_item: ');
            $this->cart_item = new Cart();
            Log::debug('['.__METHOD__.'] $this->cart_item: ' . json_encode($this->cart_item));
        }
    }

    public function addToCart($id)
    {
        try {
            Log::debug('['.__METHOD__.'] $id: ' . json_encode($id));
            $product = Products::where('sku', $id)->first();
            Log::debug('['.__METHOD__.'] $product: ' . json_encode($product));
            if(empty($product)) {
                return $this->responseFormat(400,'product not exist!');
            }
            if($product->qty == 0) {
                return $this->responseFormat(400,'out of stock!');
            }
//            session()->flash('cart');
            $cart = $this->cart_item->add($id);
            Log::debug('['.__METHOD__.'] $cart: ' . json_encode($cart));
            return $this->responseFormat( 200, 'Product added to cart successfully!');
        } catch (Exception $exception) {
            return $this->responseFormat(400,'Product added to cart fail!');
        }
    }

    public function getAllData()
    {
        try{
            $return = [
                'data' => $this->cart_item->getAllData(),
                'count' => $this->cart_item->count(),
            ];
            return $this->responseFormat(200,'Success',$return);
        } catch(Exception $exception) {
            return $this->responseFormat(400,'Get data fail!');
        }

    }

    /**
     * response format in this service
     * @param  $code
     * @param  $msg
     * @param  $data
     *
     * @return array
     *
     */
    private function responseFormat($code, $msg, $data = []): array
    {
        return [
            'status' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }

}

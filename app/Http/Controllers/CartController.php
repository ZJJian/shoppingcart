<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    /**
     * get Product Data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function cartPage()
    {
        $cart_service = new CartService();
        $result = $cart_service->getAllData();
        Log::debug('[cartPage] result: ' . json_encode($result));
        return view()->first(['cart'], $result['data']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function addToCart($id)
    {
        try {

            $param = [
                'sku' => $id,
            ];
            $validator = Validator::make($param, [
                'sku' => 'required|String|max:10',
            ]);
            if ($validator->fails()) {
                Log::error('[addToCart] valid fail: ' . $validator->messages());
                throw new Exception(' valid fail: ' . $validator->messages(), 400);
            }
            $cart_service = new CartService();
            $result =$cart_service->addToCart($id);

            if($result['status'] == 200) {
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            } else {
                redirect()->back()->with('fail', $result['msg']);
            }
        } catch (Exception $exception) {
            return redirect()->back()->with('fail', 'Product added to cart fail!');
        }
    }

    /**
     * cart update
     *
     * @return array
     */
    public function updateCart(Request $request)
    {
        $param['id'] = $request->id;
        $param['quantity'] = $request->quantity;
        $validator = Validator::make($param, [
            'id' => 'required|String|max:10',
            'quantity' => 'required|integer'
        ]);
        if ($validator->fails()) {
            Log::error('[addToCart] valid fail: ' . $validator->messages());
            throw new Exception(' valid fail: ' . $validator->messages(), 400);
        }
        Log::debug('[updateCart] ' . json_encode($param));
        $cart_service = new CartService();
        $result = $cart_service->updateCart($param);
        $result = $cart_service->getAllData();
        Log::debug('[cartPage] result: ' . json_encode($result));
        return ['results' =>  $result['data']];
    }

}

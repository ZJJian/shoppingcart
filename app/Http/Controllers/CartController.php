<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    /**
     * get Product Data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $cart_service = new CartService();
        $result = $cart_service->getAllData();
        Log::debug('[cartPage] result: ' . json_encode($result));
        return view()->first(['cart'], $result['data']);
    }

    /**
     * @param $id
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function addCart(Request $request)
    {
        try {

            $param = [
                'sku' => $request->id,
            ];
            $validator = Validator::make($param, [
                'sku' => 'required|String|max:10',
            ]);
            if ($validator->fails()) {
                Log::error('[addToCart] valid fail: ' . $validator->messages());
                throw new Exception(' valid fail: ' . $validator->messages(), 400);
            }
            $cart_service = new CartService();
            $result =$cart_service->addToCart($param['sku']);

            return ['results' => $result];
        } catch (Exception $exception) {
            return ['results' => ['status' => 400, 'msg' => 'Product added to cart fail!']];
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

    public function checkout() {
        $this->authCheck();
        $cart_service = new CartService();
        $result = $cart_service->getAllData();
        return view()->first(['checkout'], $result['data']);
    }

    public function checkoutSubmit(Request $request) {
//        $this->authCheck();
        $param = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        Log::debug('[cartPage] checkoutSubmit : ' . json_encode($param));
//        $cart_service = new CartService();
//        $result = $cart_service->getAllData();
        return redirect()->route('placeorder');
        //return view()->first(['checkout'], $result['data']);
    }


    /**
     * get Product Data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function placeorder()
    {
        return view()->first(['placeorder']);
    }

    public function authCheck() {
        if (!isset(Auth::guard()->user()->email)) {
            return redirect()->route('login');
        }
    }



}

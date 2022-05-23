<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    /**
     * get Cart Data
     *
     * @return View
     */
    public function index(): View
    {
        $cart_service = new CartService();
        $result = $cart_service->getAllData();
        Log::debug('[cartPage] result: ' . json_encode($result));
        return view()->first(['cart'], $result['data']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function addCart(Request $request): array
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
     * @throws Exception
     */
    public function updateCart(Request $request): array
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

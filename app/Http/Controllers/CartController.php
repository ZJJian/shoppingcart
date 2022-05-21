<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Services\Cart\CartService;
use Exception;
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
        if($result['status'] == 200) {
            return view()->first(['cart'], $result['data']);
        } else {
            return view()->first(['cart'], []);
        }
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

}

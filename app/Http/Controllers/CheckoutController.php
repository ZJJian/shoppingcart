<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * place order success page
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $cart_service = new CartService();
        $result = $cart_service->getAllData();
        return view()->first(['checkout'], $result['data']);
    }

    /**
     * place order success page
     *
     * @param Request $request
     *
     */
    public function checkoutSubmit(Request $request)
    {
        $cart_service = new CartService();
        $cart_data = $cart_service->getAllData();
        $param = [
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'item' => $cart_data,
        ];
        Log::debug('[cartPage] checkoutSubmit : ' . json_encode($param));
        $checkout_service = New CheckoutService();
        $result = $checkout_service->creatOrder($param);

//        return $result;

        return redirect()->route('checkout.placeorder');
    }

    /**
     * place order success page
     *
     * @return View
     */
    public function placeOrder(): View
    {
        return view()->first(['placeorder']);
    }

}

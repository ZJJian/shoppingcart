<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
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
     * @return RedirectResponse
     */
    public function checkoutSubmit(Request $request): RedirectResponse
    {
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

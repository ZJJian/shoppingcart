<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

        if(isset($result['data']['count']) && $result['data']['count'] > 0) {
            return view()->first(['checkout'], $result['data']);
        } else {
            return redirect()->route('cart.index');
        }

    }

    /**
     * place order success page
     *
     * @param Request $request
     *
     */
    public function checkoutSubmit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate($request,[
            'name' => 'required|min:3|max:35',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ],[
            'name.required' => ' The name field is required.',
            'name.min' => ' The name must be at least 3 characters.',
            'name.max' => ' The name may not be greater than 35 characters.',
            'address.required' => ' The address field is required.',
            'email.required' => ' The email field is required.',
            'phone.required' => ' The phone field is required and should be numeric.',

        ]);

        $param = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'items' => json_decode($request->cart,true),
        ];

        $checkout_service = New CheckoutService();
        $result = $checkout_service->creatOrder($param);
        Log::debug('[Checkout] checkoutSubmit $result: ' . json_encode($result));

        $data = [
            'title' => ($result['code'] == 200) ? 'Your Order Has Been Placed' :'Your Order Placed Failed',
            'message' => ($result['code'] == 200) ? 'Thank you for ordering with us.' : 'Please try it later.',
        ];

        return redirect()->route('checkout.placeorder')->with($data);
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

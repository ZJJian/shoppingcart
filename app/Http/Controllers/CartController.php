<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    /**
     * get Product Data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function cartPage()
    {
//        $product_result = Products::getProducts();
        $cart = session()->get('cart');
        Log::debug('[cartPage] $cart: ' . json_encode($cart));
        $count = $cart['count'];
        unset($cart['count']);
        $result = [
            'count' => $count,
            'data' => $cart,
        ];
        Log::debug('[cartPage] result: ' . json_encode($result));
        return view()->first(['cart'], $result);
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
            Log::debug('[addToCart] $id: ' . json_encode($id));
            $product = Products::where('sku', $id)->first();
            Log::debug('[addToCart] $product: ' . json_encode($product));
            if(empty($product)) {
                redirect()->back()->with('fail', 'product not exist!');
            }
            if($product->qty == 0) {
                redirect()->back()->with('fail', 'out of stock!');
            }
            $cart = session()->get('cart');
            Log::debug('[addToCart] $cart: ' . json_encode($cart));
            // if cart is empty then this the first product
            if(!$cart) {
                $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => $product->image
                    ],
                    "count" => 1,
                ];
                session()->put('cart', $cart);
                $new_cart = session()->get('cart');
                Log::debug('[addToCart] $new_cart1: ' . json_encode($new_cart));
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
            // if cart not empty then check if this product exist then increment quantity
            if(isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart['count']= $cart[$id]['quantity'];
                session()->put('cart', $cart);
                $new_cart = session()->get('cart');
                Log::debug('[addToCart] $new_cart2: ' . json_encode($new_cart));
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
            // if item not exist in cart then add to cart with quantity = 1
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "photo" => $product->image
                ],
                "count" => 1,
            ];
            session()->put('cart', $cart);
            $new_cart = session()->get('cart');
            Log::debug('[addToCart] $new_cart3: ' . json_encode($new_cart));
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } catch (Exception $exception) {
            return redirect()->back()->with('fail', 'Product added to cart fail!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Exception;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    /**
     * get Product Data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function shopList()
    {
        $product_result = Products::getProducts();
        return view()->first(['shop_index'], $product_result);
    }

}


<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    /**
     * get Product Data
     *
     * @return View
     */
    public function index(): View
    {
        $product_result = Products::getProducts();
        return view()->first(['shop'], $product_result);
    }

}


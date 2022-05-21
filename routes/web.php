<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('shop', [ShopController::class, 'shopList'])->name('shop.index');
Route::get('cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart', [CartController::class, 'cartPage'])->name('shop.cart');

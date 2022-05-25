<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * get Product Data
     *
     * @return View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user()->toArray();

        $result = [
            'name' => $user['name'],
            'email' => $user['email'],
        ];

        $result = User::getOrders(Auth::id());
        Log::debug('user: ' . json_encode($result, JSON_PRETTY_PRINT));
        return view()->first(['user'], $result);
    }


}

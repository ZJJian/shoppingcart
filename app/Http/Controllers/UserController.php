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
        Log::debug('[UserController] $user: ' . json_encode($user));
        Log::debug('[UserController] name: ' . json_encode($user['name']));

        $result = [
            'name' => $user['name'],
            'email' => $user['email'],
        ];
        Log::debug('[UserController] $result: ' . json_encode($result));

        $result = User::getOrders(Auth::id());
        Log::debug('user: ' . json_encode($result, JSON_PRETTY_PRINT));
        return view()->first(['user'], $result);
    }


}

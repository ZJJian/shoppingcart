<?php

namespace App\Http\Controllers;

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

        return view()->first(['user'], $result);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // Lấy user đang đăng nhập
        $user = Auth::user();
        $customer = $user->customer;
        return view('auth.profile', compact('user','customer'));
    }
}

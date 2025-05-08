<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerBookingController extends Controller
{
    public function history()
{
    $account = Auth::user(); // Tài khoản đang đăng nhập

    if (!$account || !$account->customer) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử đặt phòng.');
    }

    $customer = $account->customer;
    $bookings = $customer->bookings()->latest()->get();

    return view('crud_customer.booking-history', compact('bookings'));
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountRegisterController extends Controller
{
    //Hiển thị form đăng ký
    public function showForm()
    {
        return view('auth.register');
    }

    // Chức năng đăng ký tài khoản
    //Xử lý dữ liệu người dùng khi gửi form
    public function register(Request $request)
    {
        //Dữ liệu đầu vào
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'birth_day' => 'required|date',
            'username' => 'required|string|unique:account,username',
            'password' => 'required|string|min:6|confirmed',
        ]);
        //Tạo bảng khách hàng trong bảng Customer
        $customer = Customer::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_day' => $request->birth_day,
            'registration_date' => now(),
        ]);
        //Tạo tài khoản và liên kết với khách hàng
        Account::create([
            'customer_id' => $customer->id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'admin_id' => 2, // 1 admin , 2 user
            'status' => 1,
        ]);
        //Đi đến form đăng nhập sau khi đăng ký thành công
        return redirect()->route('login')->with('success', 'Tạo tài khoản thành công!');
    }
}

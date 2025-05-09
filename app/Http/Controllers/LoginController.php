<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //showform login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'username' => 'required|string',   // Kiểm tra username là bắt buộc
            'password' => 'required|min:6',    // Kiểm tra mật khẩu là bắt buộc và ít nhất 6 ký tự
        ]);

        // Kiểm tra username và password
        $account = Account::where('username', $request->username)->first();

        // Kiểm tra nếu tài khoản tồn tại và mật khẩu đúng
        if ($account && Hash::check($request->password, $account->password)) {
            Auth::login($account); // Đăng nhập

            $bookingCount = BookingService::where('customer_id', $account->id)->count();
            session(['booking_count' => $bookingCount]);

            return redirect()->route('home')->with('success', 'Đăng nhập thành công!'); // Đưa người dùng đến home hoặc trang cần thiết
        }

        // Nếu đăng nhập không thành công
        return back()->withErrors([
            'username' => 'Tên đăng nhập hoặc mật khẩu không chính xác.',
        ]);
    }

    // Xử lý đăng xuất
    public function logout()
    {
        session()->forget('booking_count');
        Auth::logout();
        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }
}

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

            // Lấy số lượng booking
            $bookingCount = BookingService::where('customer_id', auth()->user()->id)
                ->where('status', 'pending')
                ->count();
            session(['booking_count' => $bookingCount]);
            
            // Lưu thông tin về vai trò của người dùng vào session
            if ($account->adminRole) {
                session(['user_role' => $account->adminRole->role_name]);
            } else {
                session(['user_role' => 'Customer']);
            }

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
        session()->forget(['booking_count', 'user_role']);
        Auth::logout();
        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }
}

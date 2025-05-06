<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])(?!.*\s).+$/',
        ],
    ], [
        'new_password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số, 1 ký tự đặc biệt và không chứa khoảng trắng.',
        'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
    ]);

    $account = Auth::user(); // Lấy tài khoản đang đăng nhập

    if (!Hash::check($request->current_password, $account->password)) {
        return back()->with('error', 'Mật khẩu hiện tại không đúng.');
    }

    $account->password = Hash::make($request->new_password);
    $account->save();

    return back()->with('success', 'Đổi mật khẩu thành công.');
}
}

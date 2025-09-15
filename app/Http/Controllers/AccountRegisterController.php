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

       //Chuyển đổi dạng full-width sang half width
    private function convertFullWidthToHalfWidth($string)
    {
        return mb_convert_kana($string, 'n', 'UTF-8'); // 'n' là chuyển số full-width → half-width
    }
    

    // Chức năng đăng ký tài khoản
    //Xử lý dữ liệu người dùng khi gửi form
    public function register(Request $request)
    {
        //Dữ liệu đầu vào
         $request->merge([
            'phone' => $this->convertFullWidthToHalfWidth($request->input('phone')),
        ]);

        $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u' // Chỉ chữ cái và dấu cách (không số, không ký tự đặc biệt)
            ],
            'email' => [
                'required',
                'email',
                'unique:customer,email', // Không được trùng
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
                // Định dạng abc@gmail.com
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
                'unique:customer,phone', // Không được trùng
                'regex:/^(0|\+84)[0-9]{9}$/'
                // Định dạng: 0123456789 hoặc +84123456789 (10 số)
            ],
            'address' => 'required|string',
            'birth_day' => [
                'required',
                'date',
                'before:today',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'username' => [
                'required',
                'string',
                'unique:account,username',
                'regex:/^[a-zA-Z0-9_]+$/'
                // Chỉ chứa chữ, số, gạch dưới
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
                // Ít nhất 1 chữ hoa, 1 chữ thường, 1 số, 1 ký tự đặc biệt
            ],
        ], [
            'full_name.required' => '"Vui lòng nhập họ và tên!"',
            'full_name.regex' => 'Họ tên chỉ được chứa chữ cái và dấu cách. Không được chứa ký tự đặc biệt và số !',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải đúng định dạng abc@gmail.com.',
            'email.unique' => 'Email đã tồn tại.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại phải đúng định dạng 0123456789 hoặc +84123456789.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',

            'address.required' => 'Địa chỉ không được để trống.',

            'birth_day.required' => 'Ngày tháng năm sinh không được để trống.',
            'birth_day.date' => 'Ngày sinh phải là một ngày hợp lệ.',
            'birth_day.before' => 'Ngày sinh không được là ngày trong tương lai.',
            'birth_day.before_or_equal' => 'Bạn phải đủ 18 tuổi trở lên.',
            
            'username.required' => 'Tên đăng nhập không được để trống.',
            'username.regex' => 'Tên đăng nhập chỉ được chứa chữ, số và dấu gạch dưới.',
            'username.unique' => 'Tên đăng nhập đã tồn tại.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên',
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
            'status' => 1, //1 Còn hoạt động , 2 không hoạt động
        ]);
        //Đi đến form đăng nhập sau khi đăng ký thành công
        return redirect()->route('login')->with('success', 'Tạo tài khoản thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CRUD_CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    /*public function list()
    {
        $customers = Customer::all();
        return view('crud_customer.list', compact('customers'));
    }*/

    //Hiển thị danh sách khách hàng có phân trang và tìm kiếm khách hàng
    public function list(Request $request)
    {
        $query = Customer::query();

        // Nếu có từ khóa tìm kiếm
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where('full_name', 'like', '%' . $keyword . '%');
        }

        // Sắp xếp ID mới nhất và phân trang 10 dòng mỗi trang
        $customers = $query->orderBy('id', 'desc')->paginate(10);

        return view('crud_customer.list', compact('customers'));
    }
    // Hiển thị thông tin chi tiết khách hàng
    public function detail($id)
    {
        $customer = Customer::findOrFail($id);
        return view('crud_customer.detail', compact('customer'));
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('crud_customer.edit', compact('customer'));
    }

    // Cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZÀ-ỹ\s]+$/u' // Cho phép chữ cái có dấu và khoảng trắng
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^(0|\+84)[0-9]{8,14}$/'
            ],
            'address' => 'required|string|max:255',
            'birth_day' => 'required|date',
        ], [
            'full_name.required' => 'Họ tên không được để trống.',
            'full_name.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng.',
            'full_name.max' => 'Họ tên không được vượt quá 255 ký tự.',
        
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
        
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 hoặc +84 và có 9 số theo sau.',
        
            'address.required' => 'Địa chỉ không được để trống.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        
            'birth_day.required' => 'Ngày sinh không được để trống.',
            'birth_day.date' => 'Ngày sinh phải là ngày hợp lệ.',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.list')->with('success', 'Cập nhật thông tin khách hàng thành công!');
    }


    // Xóa khách hàng
    public function delete($id)
    {
        $customer = Customer::findOrFail($id);

        // Xóa account nếu tồn tại
        if ($customer->account) {
            $customer->account->delete();
        }

        // Sau đó xóa customer
        $customer->delete();

        return redirect()->route('customers.list')->with('success', 'Xóa khách hàng thành công.');
    }
}

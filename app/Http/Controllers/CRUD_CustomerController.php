<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CRUD_CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function list()
    {
        $customers = Customer::all();
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
                'regex:/^[a-zA-ZÀ-ỹ\s]+$/u' // Chỉ cho phép chữ cái và khoảng trắng
            ],
            'email' => 'required|email|max:255', // Ký tự tối đa 255
            'phone' => 'required|string|max:15', // Ký tự tối đa 15
            'address' => 'required|string|max:255', //Ký tự tối đa 255
            'birth_day' => 'required|date',
        ], [
            'full_name.regex' => 'Họ tên chỉ được chứa chữ cái và khoảng trắng.',
            'email.email' => 'Email phải đúng định dạng.',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('crud_customer.list')->with('success', 'Cập nhật thông tin khách hàng thành công!');
    }


    // Xóa khách hàng
    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('crud_customer.list')->with('success', 'Xóa khách hàng thành công!');
    }
}

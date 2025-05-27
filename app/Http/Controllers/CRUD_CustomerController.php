<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;

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

        // Lấy số trang hiện tại
        $page = $request->query('page', 1);

        // Kiểm tra nếu page không phải số nguyên dương
        if (!ctype_digit((string) $page) || (int) $page < 1) {
            return redirect()->route('customers.list')->with('error', 'Số trang không hợp lệ.');
        }

        // Phân trang
        $customers = $query->orderBy('id', 'desc')->paginate(10);

        // Nếu người dùng nhập page vượt quá số trang có sẵn
        if ($page > $customers->lastPage()) {
            return redirect()->route('customers.list')->with('error', 'Trang không tồn tại.');
        }

        return view('crud_customer.list', compact('customers'));
    }
    // Hiển thị thông tin chi tiết khách hàng
    public function detail($id)
    {
        // Kiểm tra ID có phải là số không
        if (!is_numeric($id)) {
            return redirect()->route('customers.list')->with('error', 'ID không hợp lệ hoặc trang không tồn tại.');
        }

        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->route('customers.list')->with('error', 'Khách hàng không tồn tại hoặc đã bị xóa.');
        }

        return view('crud_customer.detail', compact('customer'));
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        // Kiểm tra nếu ID không phải là số nguyên dương
        if (!ctype_digit($id)) {
            return redirect()->route('customers.list')
                ->with('error', 'ID không hợp lệ hoặc trang bạn yêu cầu không tồn tại.');
        }

        // Tìm customer theo ID
        $customer = Customer::find($id);

        // Nếu không tìm thấy
        if (!$customer) {
            return redirect()->route('customers.list')
                ->with('error', 'ID không tồn tại hoặc trang bạn yêu cầu không tồn tại.');
        }

        return view('crud_customer.edit', compact('customer'));
    }

    //Chuyển đổi dạng full-width sang half width
    private function convertFullWidthToHalfWidth($string)
    {
        return mb_convert_kana($string, 'n', 'UTF-8'); // 'n' là chuyển số full-width → half-width
    }
    // Cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        $request->merge([
            'phone' => $this->convertFullWidthToHalfWidth($request->input('phone')),
        ]);
        $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZÀ-ỹ\s]+$/u'
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
            'birth_day' => [
                'required',
                'date',
                'before_or_equal:today',
                'before:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'updated_at' => 'required|date' // thêm để bắt buộc có trường này
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
            'birth_day.before_or_equal' => 'Ngày sinh không được nằm trong tương lai.',
            'birth_day.before' => 'Khách hàng phải từ 18 tuổi trở lên.',
        ]);

        $customer = Customer::findOrFail($id);

        $clientUpdatedAt = Carbon::createFromFormat('Y-m-d H:i:s.u', $request->input('updated_at'));

        if (!$customer->updated_at->equalTo($clientUpdatedAt)) {
            return back()
                ->withInput()
                ->with('error', 'Dữ liệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang để tiếp tục cập nhật.');
        }
        //  Cập nhật dữ liệu
        $customer->update($request->except('updated_at'));

        return redirect()->route('customers.list')->with('success', 'Cập nhật thông tin khách hàng thành công!');
    }


    // Xóa khách hàng
    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->route('customers.list')->with('error', 'Dữ liệu đã bị xóa hoặc không tồn tại.');
        }

        // Xóa bookings nếu có
        if ($customer->bookings()->exists()) {
            $customer->bookings()->delete();
        }

        // Xóa account nếu có
        if ($customer->account) {
            $customer->account->delete();
        }

        // Xóa customer
        $customer->delete();

        return redirect()->route('customers.list')->with('success', 'Xóa khách hàng thành công.');
    }
}

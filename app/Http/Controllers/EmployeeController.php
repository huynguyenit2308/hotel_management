<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Hiển thị danh sách nhân viên
     */
    public function index(Request $request)
    {
        try {
            $query = Employee::query();

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where('full_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            }

            if ($request->has('position') && !empty($request->position)) {
                $query->where('position', $request->position);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $employees = $query->paginate(10);
            $roles = Admin::all();

            return view('employees.index', compact('employees', 'roles'));
        } catch (\Exception $e) {
            Log::error('Error in EmployeeController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải danh sách nhân viên.');
        }
    }

    /**
     * Hiển thị form tạo nhân viên mới
     */
    public function create()
    {
        try {
            $roles = Admin::all();
            return view('employees.create', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Error in EmployeeController@create: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải trang tạo nhân viên.');
        }
    }

    /**
     * Lưu thông tin nhân viên mới
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:employee,email|max:255',
                'phone' => 'required|string|unique:employee,phone|max:15',
                'address' => 'nullable|string|max:255',
                'birth_day' => 'nullable|date',
                'hire_date' => 'required|date',
                'position' => 'required|string|max:100',
                'salary' => 'required|numeric|min:0',
                'admin_id' => 'required|exists:admin,id',
                'status' => 'required|in:0,1',
            ], [
                'full_name.required' => 'Vui lòng nhập tên nhân viên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã được sử dụng',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.unique' => 'Số điện thoại đã được sử dụng',
                'hire_date.required' => 'Vui lòng nhập ngày tuyển dụng',
                'position.required' => 'Vui lòng nhập vị trí công việc',
                'salary.required' => 'Vui lòng nhập lương',
                'salary.numeric' => 'Lương phải là số',
                'admin_id.required' => 'Vui lòng chọn quyền',
                'admin_id.exists' => 'Quyền không tồn tại',
                'status.required' => 'Vui lòng chọn trạng thái',
            ]);

            Employee::create($validated);

            return redirect()->route('employees.index')
                ->with('success', 'Thêm nhân viên thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating employee: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi thêm nhân viên. Vui lòng thử lại!');
        }
    }

    /**
     * Hiển thị thông tin chi tiết nhân viên
     */
    public function show(Employee $employee)
    {
        try {
            return view('employees.show', compact('employee'));
        } catch (\Exception $e) {
            Log::error('Error in EmployeeController@show: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi xem thông tin nhân viên.');
        }
    }

    /**
     * Hiển thị form chỉnh sửa thông tin nhân viên
     */
    public function edit(Employee $employee)
    {
        try {
            $roles = Admin::all();
            return view('employees.edit', compact('employee', 'roles'));
        } catch (\Exception $e) {
            Log::error('Error in EmployeeController@edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải trang chỉnh sửa nhân viên.');
        }
    }

    /**
     * Cập nhật thông tin nhân viên
     */
    public function update(Request $request, Employee $employee)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:employee,email,' . $employee->id,
                'phone' => 'required|string|max:15|unique:employee,phone,' . $employee->id,
                'address' => 'nullable|string|max:255',
                'birth_day' => 'nullable|date',
                'hire_date' => 'required|date',
                'position' => 'required|string|max:100',
                'salary' => 'required|numeric|min:0',
                'admin_id' => 'required|exists:admin,id',
                'status' => 'required|in:0,1',
            ], [
                'full_name.required' => 'Vui lòng nhập tên nhân viên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã được sử dụng',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.unique' => 'Số điện thoại đã được sử dụng',
                'hire_date.required' => 'Vui lòng nhập ngày tuyển dụng',
                'position.required' => 'Vui lòng nhập vị trí công việc',
                'salary.required' => 'Vui lòng nhập lương',
                'salary.numeric' => 'Lương phải là số',
                'admin_id.required' => 'Vui lòng chọn quyền',
                'admin_id.exists' => 'Quyền không tồn tại',
                'status.required' => 'Vui lòng chọn trạng thái',
            ]);

            $employee->update($validated);

            return redirect()->route('employees.index')
                ->with('success', 'Cập nhật thông tin nhân viên thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại!');
        }
    }

    /**
     * Xóa nhân viên
     */
    public function destroy($id)
{
    try {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Xóa không hợp lệ. Nhân viên không tồn tại.');
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Xóa nhân viên thành công.');
    } catch (\Exception $e) {
        Log::error('Error in EmployeeController@destroy: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Đã xảy ra lỗi khi xóa nhân viên. Vui lòng thử lại.');
    }
}
} 
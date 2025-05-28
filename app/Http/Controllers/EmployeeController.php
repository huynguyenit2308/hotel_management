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
        // Kiểm tra tham số page
        $page = $request->query('page');
        if ($page !== null && (!ctype_digit($page) || (int)$page < 1)) {
            return redirect()->route('employees.index')->with('error', 'Tham số trang không hợp lệ!');
        }

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

        // Nếu page vượt quá tổng số trang, báo lỗi
        if ($page !== null && $employees->lastPage() > 0 && $page > $employees->lastPage()) {
            return redirect()->route('employees.index')->with('error', 'Trang không tồn tại!');
        }

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
            'full_name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $trimmed = preg_replace('/[\s　]+/u', '', $value);
                    if ($trimmed === '') {
                        $fail('Tên nhân viên không được chỉ chứa khoảng trắng.');
                    }
                    if ($value != strip_tags($value)) {
                        $fail('Không được nhập mã HTML vào trường ' . $attribute . '.');
                    }
                },
            ],
            'email' => 'required|email|unique:employee,email|max:255',
            'phone' => [
                'required',
                'string',
                'max:15',
                'unique:employee,phone',
                function ($attribute, $value, $fail) {
                    if (preg_match('/[０-９]/u', $value)) {
                        $fail('Số điện thoại không được chứa số full-width (０-９).');
                    }
                },
            ],
            'address' => 'nullable|string|max:255',
            'birth_day' => 'nullable|date',
            'hire_date' => 'required|date',
            'position' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    $trimmed = preg_replace('/[\s　]+/u', '', $value);
                    if ($trimmed === '') {
                        $fail('Vị trí không được chỉ chứa khoảng trắng.');
                    }
                    if ($value != strip_tags($value)) {
                        $fail('Không được nhập mã HTML vào trường ' . $attribute . '.');
                    }
                },
            ],
            'salary' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if (preg_match('/[０-９]/u', $value)) {
                        $fail('Lương không được chứa số full-width (０-９).');
                    }
                },
            ],
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
   public function update(Request $request, $id)
{
     try {
        $employee = Employee::find($id);
        if (!$employee) {
            return redirect()->route('employees.index')->with('error', 'Cập nhật không hợp lệ. Nhân viên không tồn tại.');
        }

        // Kiểm tra xung đột dữ liệu
        if ($request->has('updated_at') && $employee->updated_at != $request->input('updated_at')) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Dữ liệu đã bị thay đổi. Vui lòng tải lại trang trước khi cập nhật!');
        }
        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $trimmed = preg_replace('/[\s　]+/u', '', $value);
                    if ($trimmed === '') {
                        $fail('Tên nhân viên không được chỉ chứa khoảng trắng.');
                    }
                    if ($value != strip_tags($value)) {
                        $fail('Không được nhập mã HTML vào trường ' . $attribute . '.');
                    }
                },
            ],
            'email' => 'required|email|max:255|unique:employee,email,' . $id,
            'phone' => [
                'required',
                'string',
                'max:15',
                'unique:employee,phone,' . $id,
                function ($attribute, $value, $fail) {
                    if (preg_match('/[０-９]/u', $value)) {
                        $fail('Số điện thoại không được chứa số full-width (０-９).');
                    }
                },
            ],
            'address' => 'nullable|string|max:255',
            'birth_day' => 'nullable|date',
            'hire_date' => 'required|date',
            'position' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    $trimmed = preg_replace('/[\s　]+/u', '', $value);
                    if ($trimmed === '') {
                        $fail('Vị trí không được chỉ chứa khoảng trắng.');
                    }
                    if ($value != strip_tags($value)) {
                        $fail('Không được nhập mã HTML vào trường ' . $attribute . '.');
                    }
                },
            ],
            'salary' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if (preg_match('/[０-９]/u', $value)) {
                        $fail('Lương không được chứa số full-width (０-９).');
                    }
                },
            ],
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
<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountPermissionController extends Controller
{
    /**
     * Hiển thị danh sách account để phân quyền
     */
    public function index()
    {
        try {
            $accounts = Account::with(['customer', 'adminRole'])->paginate(10);
            $roles = Admin::all();
            
            return view('permissions.index', compact('accounts', 'roles'));
        } catch (\Exception $e) {
            Log::error('Error in AccountPermissionController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải danh sách tài khoản.');
        }
    }

    /**
     * Hiển thị form chỉnh sửa quyền cho tài khoản
     */
    public function edit($id)
    {
        try {
            $account = Account::with(['customer', 'adminRole'])->findOrFail($id);
            $roles = Admin::all();
            
            // Kiểm tra xem account đã là nhân viên chưa
            $isEmployee = Employee::where('email', $account->customer->email)->exists();
            
            return view('permissions.edit', compact('account', 'roles', 'isEmployee'));
        } catch (\Exception $e) {
            Log::error('Error in AccountPermissionController@edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tải thông tin tài khoản.');
        }
    }

    /**
     * Cập nhật quyền cho tài khoản
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'admin_id' => 'required|exists:admin,id',
                'make_employee' => 'nullable|boolean',
            ], [
                'admin_id.required' => 'Vui lòng chọn quyền',
                'admin_id.exists' => 'Quyền không tồn tại',
            ]);

            $account = Account::with('customer')->findOrFail($id);
            
            // Cập nhật quyền cho tài khoản
            $account->admin_id = $validated['admin_id'];
            $account->save();
            
            // Nếu chọn tạo nhân viên
            if ($request->has('make_employee') && $request->make_employee == 1) {
                // Kiểm tra xem đã có nhân viên với email này chưa
                $employee = Employee::where('email', $account->customer->email)->first();
                
                if (!$employee) {
                    // Tạo nhân viên mới từ thông tin khách hàng
                    Employee::create([
                        'full_name' => $account->customer->full_name,
                        'email' => $account->customer->email,
                        'phone' => $account->customer->phone,
                        'address' => $account->customer->address,
                        'birth_day' => $account->customer->birth_day,
                        'hire_date' => now(),
                        'position' => 'Nhân viên mới',
                        'salary' => 0,
                        'admin_id' => $validated['admin_id'],
                        'status' => 1
                    ]);
                    
                    return redirect()->route('permissions.index')->with('success', 'Đã cập nhật quyền và thêm tài khoản vào danh sách nhân viên.');
                }
                
                // Nếu đã là nhân viên, chỉ cập nhật quyền
                $employee->admin_id = $validated['admin_id'];
                $employee->save();
            }
            
            return redirect()->route('permissions.index')->with('success', 'Đã cập nhật quyền cho tài khoản.');
        } catch (\Exception $e) {
            Log::error('Error in AccountPermissionController@update: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật quyền. Vui lòng thử lại!');
        }
    }
} 
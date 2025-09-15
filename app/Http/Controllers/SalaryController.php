<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SalaryController extends Controller
{
    /**
     * Hiển thị trang quản lý lương
     */
    public function index(Request $request)
    {
        try {
            $query = Employee::query();

            // Tìm kiếm theo tên, email, số điện thoại
            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('full_name', 'like', "%{$searchTerm}%")
                        ->orWhere('email', 'like', "%{$searchTerm}%")
                        ->orWhere('phone', 'like', "%{$searchTerm}%");
                });
            }

            // Lọc theo vị trí
            if ($request->has('position') && $request->position) {
                $query->where('position', $request->position);
            }

            // Lọc theo trạng thái
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            // Sắp xếp theo lương
            if ($request->has('sort_by') && $request->sort_by) {
                $sortDirection = $request->sort_direction ?? 'asc';
                $query->orderBy($request->sort_by, $sortDirection);
            } else {
                $query->orderBy('salary', 'desc');
            }

            $employees = $query->paginate(10);
            
            return view('salaries.index', compact('employees'));
        } catch (\Exception $e) {
            Log::error('Error in SalaryController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form cập nhật lương
     */
    public function edit($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return view('salaries.edit', compact('employee'));
        } catch (\Exception $e) {
            Log::error('Error in SalaryController@edit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật lương nhân viên
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'salary' => 'required|numeric|min:0',
                'effective_date' => 'nullable|date',
                'reason' => 'nullable|string|max:255',
            ]);

            $employee = Employee::findOrFail($id);
            
            // Lưu lại lương cũ để ghi log nếu cần
            $oldSalary = $employee->salary;
            
            // Cập nhật lương mới
            $employee->salary = $request->salary;
            $employee->save();
            
            // Ghi log nếu cần
            Log::info('Salary updated for employee #' . $id . ' from ' . $oldSalary . ' to ' . $request->salary . ' by admin ' . Auth::id());

            return redirect()->route('salaries.index')->with('success', 'Cập nhật lương thành công.');
        } catch (\Exception $e) {
            Log::error('Error in SalaryController@update: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hiển thị lịch sử thay đổi lương (phần mở rộng trong tương lai)
     */
    public function history($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            // Trong tương lai, có thể thêm bảng salary_history để lưu lịch sử thay đổi lương
            
            return view('salaries.history', compact('employee'));
        } catch (\Exception $e) {
            Log::error('Error in SalaryController@history: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Hiển thị danh sách chấm công theo nhân viên
     */
    public function index()
    {
        // Lấy danh sách nhân viên có chấm công, mỗi nhân viên chỉ xuất hiện một lần
        // Kèm theo thông tin tổng số giờ làm và ngày chấm công gần nhất
        $employeeAttendances = DB::table('employee')
            ->join('attendance', 'employee.id', '=', 'attendance.employee_id')
            ->select(
                'employee.id',
                'employee.full_name',
                'employee.position',
                'employee.status',
                DB::raw('COUNT(attendance.id) as attendance_count'),
                DB::raw('SUM(attendance.hours_work) as total_hours'),
                DB::raw('MAX(attendance.work_date) as latest_attendance')
            )
            ->groupBy('employee.id', 'employee.full_name', 'employee.position', 'employee.status')
            ->orderBy('latest_attendance', 'desc')
            ->paginate(10);
        
        return view('attendances.index', compact('employeeAttendances'));
    }

    /**
     * Hiển thị chi tiết chấm công của một nhân viên
     */
    public function employeeDetail($id)
    {
        $employee = Employee::findOrFail($id);
        $attendances = Attendance::where('employee_id', $id)
            ->orderBy('work_date', 'desc')
            ->get();
            
        return view('attendances.employee_detail', compact('employee', 'attendances'));
    }

    /**
     * Hiển thị form tạo chấm công mới
     */
    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    /**
     * Lưu thông tin chấm công mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'work_date' => 'required|date',
            'hours_work' => 'required|numeric|min:0|max:24',
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendances.index')
            ->with('success', 'Đã thêm thông tin chấm công thành công');
    }

    /**
     * Hiển thị form sửa chấm công
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('attendances.edit', compact('attendance', 'employees'));
    }

    /**
     * Cập nhật thông tin chấm công
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'work_date' => 'required|date',
            'hours_work' => 'required|numeric|min:0|max:24',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendances.index')
            ->with('success', 'Đã cập nhật thông tin chấm công thành công');
    }

    /**
     * Xóa thông tin chấm công
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Đã xóa thông tin chấm công thành công');
    }

    /**
     * Báo cáo lương
     */
    public function salaryReport(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        
        $salaryReports = DB::table('attendance')
            ->join('employee', 'attendance.employee_id', '=', 'employee.id')
            ->select(
                'employee.id',
                'employee.full_name',
                'employee.position',
                'employee.salary as hourly_rate',
                DB::raw('SUM(attendance.hours_work) as total_hours'),
                DB::raw('SUM(attendance.hours_work * employee.salary) as total_salary')
            )
            ->whereMonth('attendance.work_date', $month)
            ->whereYear('attendance.work_date', $year)
            ->groupBy('employee.id', 'employee.full_name', 'employee.position', 'employee.salary')
            ->get();
        
        return view('attendances.salary_report', compact('salaryReports', 'month', 'year'));
    }
} 
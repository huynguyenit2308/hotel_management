@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chi tiết chấm công: {{ $employee->full_name }}</h5>
                    <div>
                        <a href="{{ route('attendances.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Quay lại</a>
                        <a href="{{ route('attendances.create') }}?employee_id={{ $employee->id }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Thêm chấm công</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Thông tin nhân viên</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="35%">Họ và tên:</th>
                                            <td>{{ $employee->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Vị trí:</th>
                                            <td>{{ $employee->position }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ $employee->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Điện thoại:</th>
                                            <td>{{ $employee->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái:</th>
                                            <td>
                                                @if($employee->status == 1)
                                                    <span class="badge bg-success">Đang làm việc</span>
                                                @elseif($employee->status == 0)
                                                    <span class="badge bg-danger">Không hoạt động</span>
                                                @elseif($employee->status == 2)
                                                    <span class="badge bg-warning">Nghỉ phép</span>
                                                @else
                                                    <span class="badge bg-secondary">Không xác định</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Thống kê chấm công</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body py-3">
                                                    <h3 class="mb-0">{{ $attendances->count() }}</h3>
                                                    <p class="mb-0">Tổng số lần chấm công</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-success text-white">
                                                <div class="card-body py-3">
                                                    <h3 class="mb-0">{{ $attendances->sum('hours_work') }}</h3>
                                                    <p class="mb-0">Tổng số giờ làm</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-info text-white">
                                                <div class="card-body py-3">
                                                    <h3 class="mb-0">{{ number_format($attendances->sum('hours_work') * $employee->salary) }}</h3>
                                                    <p class="mb-0">Tổng lương (VNĐ)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body py-3">
                                                    <h3 class="mb-0">{{ number_format($employee->salary) }}</h3>
                                                    <p class="mb-0">Lương/giờ (VNĐ)</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th width="5%">ID</th>
                                    <th width="25%">Ngày làm việc</th>
                                    <th width="20%">Số giờ làm</th>
                                    <th width="25%">Ngày tạo</th>
                                    <th width="25%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attendances as $attendance)
                                    <tr>
                                        <td class="text-center">{{ $attendance->id }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($attendance->work_date)->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ $attendance->hours_work }} giờ</td>
                                        <td class="text-center">{{ $attendance->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Không có dữ liệu chấm công nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
</style>
@endsection 
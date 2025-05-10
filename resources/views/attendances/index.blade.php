@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách nhân viên chấm công</h5>
                    <div>
                        <a href="{{ route('attendances.create') }}" class="btn btn-light"><i class="fas fa-plus-circle"></i> Thêm chấm công</a>
                        <a href="{{ route('attendances.salary_report') }}" class="btn btn-success"><i class="fas fa-chart-bar"></i> Báo cáo lương</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Nhân viên</th>
                                    <th>Vị trí</th>
                                    <th>Trạng thái</th>
                                    <th>Số lần chấm công</th>
                                    <th>Tổng giờ làm</th>
                                    <th>Chấm công gần nhất</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employeeAttendances as $employee)
                                    <tr>
                                        <td class="text-center">{{ $employee->id }}</td>
                                        <td>{{ $employee->full_name }}</td>
                                        <td>{{ $employee->position }}</td>
                                        <td class="text-center">
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
                                        <td class="text-center">{{ $employee->attendance_count }}</td>
                                        <td class="text-center">{{ $employee->total_hours }} giờ</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($employee->latest_attendance)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('attendances.employeeDetail', $employee->id) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-eye"></i> Chi tiết
                                            </a>
                                            <a href="{{ route('attendances.create') }}?employee_id={{ $employee->id }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus"></i> Chấm công
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Không có dữ liệu chấm công nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <p class="text-muted mb-0">Hiển thị {{ $employeeAttendances->firstItem() ?? 0 }} đến {{ $employeeAttendances->lastItem() ?? 0 }} của {{ $employeeAttendances->total() }} nhân viên</p>
                        </div>
                        <div>
                            {{ $employeeAttendances->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-item .page-link {
        border-radius: 0.2rem;
        margin: 0 3px;
        color: #5a5c69;
        font-size: 0.9rem;
    }
    .pagination .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        color: #b7b9cc;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0.8rem;
    }
    .table th {
        font-weight: 600;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
</style>
@endsection 
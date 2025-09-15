@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý Lương Nhân viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Nhân viên</a></li>
        <li class="breadcrumb-item active">Quản lý Lương</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-money-bill-wave me-1"></i>
                Danh sách Lương Nhân viên
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('salaries.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email, điện thoại" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="position" class="form-select">
                            <option value="">-- Tất cả vị trí --</option>
                            <option value="Lễ tân" {{ request('position') == 'Lễ tân' ? 'selected' : '' }}>Lễ tân</option>
                            <option value="Phục vụ" {{ request('position') == 'Phục vụ' ? 'selected' : '' }}>Phục vụ</option>
                            <option value="Quản lý" {{ request('position') == 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                            <option value="Bảo vệ" {{ request('position') == 'Bảo vệ' ? 'selected' : '' }}>Bảo vệ</option>
                            <option value="Nhân viên vệ sinh" {{ request('position') == 'Nhân viên vệ sinh' ? 'selected' : '' }}>Nhân viên vệ sinh</option>
                            <option value="Đầu bếp" {{ request('position') == 'Đầu bếp' ? 'selected' : '' }}>Đầu bếp</option>
                            <option value="Kế toán" {{ request('position') == 'Kế toán' ? 'selected' : '' }}>Kế toán</option>
                            <option value="Nhân viên kỹ thuật" {{ request('position') == 'Nhân viên kỹ thuật' ? 'selected' : '' }}>Nhân viên kỹ thuật</option>
                            <option value="Nhân viên nhà hàng" {{ request('position') == 'Nhân viên nhà hàng' ? 'selected' : '' }}>Nhân viên nhà hàng</option>
                            <option value="Quản lý nhân sự" {{ request('position') == 'Quản lý nhân sự' ? 'selected' : '' }}>Quản lý nhân sự</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="sort_by" class="form-select">
                            <option value="salary" {{ request('sort_by') == 'salary' ? 'selected' : '' }}>Sắp xếp theo lương</option>
                            <option value="full_name" {{ request('sort_by') == 'full_name' ? 'selected' : '' }}>Sắp xếp theo tên</option>
                            <option value="hire_date" {{ request('sort_by') == 'hire_date' ? 'selected' : '' }}>Sắp xếp theo ngày tuyển</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-3">
                        <select name="sort_direction" class="form-select">
                            <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                            <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Lọc
                        </button>
                        <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo me-1"></i> Đặt lại
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Vị trí</th>
                            <th>Lương hiện tại</th>
                            <th>Ngày tuyển dụng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2 bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 1rem;">
                                        {{ strtoupper(substr($employee->full_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $employee->full_name }}</div>
                                        <div class="small text-muted">{{ $employee->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->position }}</td>
                            <td class="fw-bold text-primary">{{ number_format($employee->salary, 0, ',', '.') }} VNĐ</td>
                            <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($employee->status == 1)
                                <span class="badge bg-success">Đang làm việc</span>
                                @elseif($employee->status == 0)
                                <span class="badge bg-danger">Đã nghỉ việc</span>
                                @elseif($employee->status == 2)
                                <span class="badge bg-warning">Nghỉ phép</span>
                                @else
                                <span class="badge bg-secondary">Không xác định</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('salaries.edit', $employee->id) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i> Cập nhật lương
                                    </a>
                                    @if(false) {{-- Tính năng lịch sử thay đổi lương (mở rộng trong tương lai) --}}
                                    <a href="{{ route('salaries.history', $employee->id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-history"></i> Lịch sử
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Không có dữ liệu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted mb-0">Hiển thị {{ $employees->firstItem() ?? 0 }} đến {{ $employees->lastItem() ?? 0 }} của {{ $employees->total() }} nhân viên</p>
                </div>
                <div>
                    {{ $employees->onEachSide(1)->links('pagination::bootstrap-5') }}
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
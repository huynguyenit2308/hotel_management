@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý Nhân viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Nhân viên</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Danh sách Nhân viên
            </div>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Thêm Nhân viên</a>
        </div>
        <div class="card-body">
            <form action="{{ route('employees.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email, điện thoại" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="position" class="form-select">
                            <option value="">-- Tất cả vị trí --</option>
                            <option value="Manager" {{ request('position') == 'Manager' ? 'selected' : '' }}>Quản lý</option>
                            <option value="Receptionist" {{ request('position') == 'Receptionist' ? 'selected' : '' }}>Lễ tân</option>
                            <option value="Housekeeping" {{ request('position') == 'Housekeeping' ? 'selected' : '' }}>Dọn phòng</option>
                            <option value="Security" {{ request('position') == 'Security' ? 'selected' : '' }}>Bảo vệ</option>
                            <option value="Maintenance" {{ request('position') == 'Maintenance' ? 'selected' : '' }}>Bảo trì</option>
                            <option value="Kitchen" {{ request('position') == 'Kitchen' ? 'selected' : '' }}>Nhà bếp</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="status" class="form-select">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang làm việc</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã nghỉ việc</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Đặt lại</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Vị trí</th>
                            <th>Lương</th>
                            <th>Ngày tuyển dụng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ number_format($employee->salary, 0, ',', '.') }} VNĐ</td>
                            <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($employee->status == 1)
                                <span class="badge bg-success">Đang làm việc</span>
                                @else
                                <span class="badge bg-danger">Đã nghỉ việc</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có nhân viên nào</td>
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
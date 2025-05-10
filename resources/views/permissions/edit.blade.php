@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Phân quyền Tài khoản</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Phân quyền</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa quyền</li>
    </ol>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-tag me-1"></i>
                    Thông tin tài khoản
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 150px;">ID:</th>
                                <td>{{ $account->id }}</td>
                            </tr>
                            <tr>
                                <th>Tên đầy đủ:</th>
                                <td>{{ $account->customer->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Username:</th>
                                <td>{{ $account->username }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $account->customer->email }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại:</th>
                                <td>{{ $account->customer->phone }}</td>
                            </tr>
                            <tr>
                                <th>Quyền hiện tại:</th>
                                <td>
                                    @if($account->adminRole)
                                        <span class="badge {{ $account->adminRole->role_name == 'Super Admin' ? 'bg-danger' : ($account->adminRole->role_name == 'Admin' ? 'bg-primary' : ($account->adminRole->role_name == 'Employee' ? 'bg-success' : 'bg-secondary')) }}">
                                            {{ $account->adminRole->role_name }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning">Chưa phân quyền</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    @if($account->status == 1)
                                    <span class="badge bg-success">Hoạt động</span>
                                    @else
                                    <span class="badge bg-danger">Khóa</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Là nhân viên:</th>
                                <td>
                                    @if($isEmployee)
                                    <span class="badge bg-success">Đã là nhân viên</span>
                                    @else
                                    <span class="badge bg-warning">Chưa là nhân viên</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-cog me-1"></i>
                    Cập nhật quyền
                </div>
                <div class="card-body">
                    <form action="{{ route('permissions.update', $account->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="admin_id" class="form-label">Phân quyền <span class="text-danger">*</span></label>
                            <select class="form-select @error('admin_id') is-invalid @enderror" id="admin_id" name="admin_id" required>
                                <option value="" disabled selected>-- Chọn quyền --</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('admin_id', $account->admin_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->role_name }} - {{ $role->description }}
                                </option>
                                @endforeach
                            </select>
                            @error('admin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!$isEmployee)
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="make_employee" name="make_employee" value="1" {{ old('make_employee') ? 'checked' : '' }}>
                            <label class="form-check-label" for="make_employee">
                                Thêm người dùng này vào danh sách nhân viên
                            </label>
                            <div class="form-text">
                                Khi chọn tùy chọn này, hệ thống sẽ tự động tạo một hồ sơ nhân viên dựa trên thông tin cá nhân hiện có.
                                Bạn có thể cập nhật thêm thông tin như vị trí, lương, ngày tuyển dụng... sau từ mục Quản lý nhân viên.
                            </div>
                        </div>
                        @endif

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Cập nhật quyền</button>
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
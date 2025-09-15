@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Thêm Nhân viên mới</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Nhân viên</a></li>
        <li class="breadcrumb-item active">Thêm nhân viên</li>
    </ol>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i>
            Thông tin nhân viên mới
        </div>
        <div class="card-body">
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="birth_day" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control @error('birth_day') is-invalid @enderror" id="birth_day" name="birth_day" value="{{ old('birth_day') }}">
                            @error('birth_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí công việc <span class="text-danger">*</span></label>
                            <select class="form-select @error('position') is-invalid @enderror" id="position" name="position" required>
                                <option value="" selected disabled>Chọn vị trí</option>
                                <option value="Manager" {{ old('position') == 'Manager' ? 'selected' : '' }}>Quản lý</option>
                                <option value="Receptionist" {{ old('position') == 'Receptionist' ? 'selected' : '' }}>Lễ tân</option>
                                <option value="Housekeeping" {{ old('position') == 'Housekeeping' ? 'selected' : '' }}>Dọn phòng</option>
                                <option value="Security" {{ old('position') == 'Security' ? 'selected' : '' }}>Bảo vệ</option>
                                <option value="Maintenance" {{ old('position') == 'Maintenance' ? 'selected' : '' }}>Bảo trì</option>
                                <option value="Kitchen" {{ old('position') == 'Kitchen' ? 'selected' : '' }}>Nhà bếp</option>
                            </select>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="hire_date" class="form-label">Ngày tuyển dụng <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date') ?? date('Y-m-d') }}" required>
                            @error('hire_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="salary" class="form-label">Lương (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="100000" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary') ?? 0 }}" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="admin_id" class="form-label">Quyền <span class="text-danger">*</span></label>
                            <select class="form-select @error('admin_id') is-invalid @enderror" id="admin_id" name="admin_id" required>
                                <option value="" selected disabled>Chọn quyền</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('admin_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                            @error('admin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Đang làm việc</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Đã nghỉ việc</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
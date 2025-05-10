@extends('dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Cập nhật Lương Nhân viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('salaries.index') }}">Quản lý Lương</a></li>
        <li class="breadcrumb-item active">Cập nhật Lương</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-money-bill-wave me-1"></i>
                    Cập nhật Lương cho {{ $employee->full_name }}
                </div>
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('salaries.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="current_salary" class="form-label">Lương hiện tại</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                <input type="text" class="form-control" id="current_salary" value="{{ number_format($employee->salary, 0, ',', '.') }} VNĐ" disabled>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="salary" class="form-label">Lương mới <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                <input type="number" class="form-control @error('salary') is-invalid @enderror" 
                                    id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" required min="0" step="100000">
                                <span class="input-group-text">VNĐ</span>
                                @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-text">Nhập số tiền không có dấu phẩy hoặc dấu chấm</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="effective_date" class="form-label">Ngày hiệu lực</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control @error('effective_date') is-invalid @enderror" 
                                    id="effective_date" name="effective_date" value="{{ old('effective_date', date('Y-m-d')) }}">
                                @error('effective_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reason" class="form-label">Lý do thay đổi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                <input type="text" class="form-control @error('reason') is-invalid @enderror" 
                                    id="reason" name="reason" value="{{ old('reason') }}" maxlength="255">
                                @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i> Cập nhật lương
                            </button>
                            <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-info-circle me-1"></i>
                    Thông tin nhân viên
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ strtoupper(substr($employee->full_name, 0, 1)) }}
                        </div>
                        <h5 class="mb-0">{{ $employee->full_name }}</h5>
                        <p class="text-muted">{{ $employee->position }}</p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span><i class="fas fa-envelope me-2"></i> Email:</span>
                            <span class="text-muted">{{ $employee->email }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span><i class="fas fa-phone me-2"></i> Điện thoại:</span>
                            <span class="text-muted">{{ $employee->phone }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span><i class="fas fa-calendar-alt me-2"></i> Ngày tuyển dụng:</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span><i class="fas fa-check-circle me-2"></i> Trạng thái:</span>
                            <span>
                                @if($employee->status == 1)
                                <span class="badge bg-success">Đang làm việc</span>
                                @else
                                <span class="badge bg-danger">Đã nghỉ việc</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thêm chấm công mới</h5>
                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('attendances.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="employee_id" class="col-md-4 col-form-label text-md-right">Nhân viên</label>
                            <div class="col-md-6">
                                <select id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" required>
                                    <option value="">-- Chọn nhân viên --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->full_name }} ({{ $employee->position }})</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="work_date" class="col-md-4 col-form-label text-md-right">Ngày làm việc</label>
                            <div class="col-md-6">
                                <input id="work_date" type="date" class="form-control @error('work_date') is-invalid @enderror" name="work_date" value="{{ old('work_date') ?? date('Y-m-d') }}" required>
                                @error('work_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="hours_work" class="col-md-4 col-form-label text-md-right">Số giờ làm</label>
                            <div class="col-md-6">
                                <input id="hours_work" type="number" class="form-control @error('hours_work') is-invalid @enderror" name="hours_work" value="{{ old('hours_work') ?? 8 }}" min="0" max="24" step="0.5" required>
                                @error('hours_work')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Lưu lại
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container padding-side">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-light rounded-top-4 text-center py-4">
                            <h1 class="mb-0">
                                <i class="bi bi-ticket-perforated me-2"></i>Thêm Voucher Mới
                            </h1>
                        </div>

                        <div class="card-body p-4 bg-white rounded-bottom-4">
                            <form action="{{ route('voucher.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="code" class="form-label fw-semibold">Mã Voucher</label>
                                    <input type="text"
                                        class="form-control rounded-3 shadow-sm @error('code') is-invalid @enderror"
                                        id="code" name="code" placeholder="Nhập mã voucher..."
                                        value="{{ old('code') }}">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label fw-semibold">Loại</label>
                                    <select class="form-select rounded-3 shadow-sm @error('type') is-invalid @enderror"
                                        name="type" id="type">
                                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Phần trăm
                                            (%)</option>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Giá cố định
                                            (VNĐ)</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="value" class="form-label fw-semibold">Giá trị</label>
                                    <input type="number"
                                        class="form-control rounded-3 shadow-sm @error('value') is-invalid @enderror"
                                        id="value" name="value" placeholder="Nhập giá trị..."
                                        value="{{ old('value') }}">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="usage_limit" class="form-label fw-semibold">Số lần sử dụng</label>
                                    <input type="number"
                                        class="form-control rounded-3 shadow-sm @error('usage_limit') is-invalid @enderror"
                                        id="usage_limit" name="usage_limit" placeholder="Nhập số lần sử dụng..."
                                        value="{{ old('usage_limit') }}">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label fw-semibold">Ngày bắt đầu</label>
                                    <input type="date"
                                        class="form-control rounded-3 shadow-sm @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date" value="{{ old('start_date') }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label fw-semibold">Ngày kết thúc</label>
                                    <input type="date"
                                        class="form-control rounded-3 shadow-sm @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date" value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="hidden" name="active" value="0">

                                    <input class="form-check-input" type="checkbox" name="active" id="active"
                                        value="1" {{ old('active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="active">Kích hoạt</label>

                                    @error('active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-3">
                                    <a href="{{ route('voucher.list') }}"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-arrow-left-circle"></i> Trở lại danh sách
                                    </a>
                                    <button type="submit"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out; border: none;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(0, 123, 255, 0.3)'"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.2)'">
                                        <i class="bi bi-check-circle"></i> Thêm Voucher
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

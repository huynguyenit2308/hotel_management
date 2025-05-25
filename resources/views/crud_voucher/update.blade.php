@extends('dashboard')

@section('content')
    @php
        use App\Helpers\IdEncoder;
        $encodedId = IdEncoder::encodeId($voucher->id);
    @endphp
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow rounded-4 p-4">
                        <h1 class="text-center mb-4">Sửa Voucher</h1>
                        <form action="{{ route('voucher.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $encodedId }}">
                            <div class="mb-3">
                                <label for="code" class="form-label fw-semibold">Mã Voucher</label>
                                <input type="text" name="code" id="code"
                                    class="form-control rounded-3 shadow-sm @error('code') is-invalid @enderror"
                                    value="{{ old('code', $voucher->code) }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Loại Voucher</label>
                                <select name="type" class="form-select shadow-sm @error('type') is-invalid @enderror">
                                    <option value="percent"
                                        {{ old('type', $voucher->type) === 'percent' ? 'selected' : '' }}>Phần trăm (%)
                                    </option>
                                    <option value="fixed" {{ old('type', $voucher->type) === 'fixed' ? 'selected' : '' }}>
                                        Giảm cố định (VNĐ)</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="value" class="form-label fw-semibold">Giá trị giảm</label>
                                <input type="number" name="value" id="value"
                                    class="form-control shadow-sm @error('value') is-invalid @enderror"
                                    value="{{ old('value', $voucher->value) }}" min="0">
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="usage_limit" class="form-label fw-semibold">Số lượt sử dụng tối đa</label>
                                <input type="number" name="usage_limit" id="usage_limit"
                                    class="form-control shadow-sm @error('usage_limit') is-invalid @enderror"
                                    value="{{ old('usage_limit', $voucher->usage_limit) }}" min="1">
                                @error('usage_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label fw-semibold">Ngày bắt đầu</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="form-control shadow-sm @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date', \Carbon\Carbon::parse($voucher->start_date)->format('Y-m-d')) }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label fw-semibold">Ngày kết thúc</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="form-control shadow-sm @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', \Carbon\Carbon::parse($voucher->end_date)->format('Y-m-d')) }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="active" id="active" value="1"
                                    {{ old('active', $voucher->active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="active">Kích hoạt</label>
                                @error('active')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-3">
                                <a href="{{ route('voucher.detail', ['id' => $encodedId]) }}"
                                    class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    style="transition: all 0.3s ease-in-out;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="bi bi-arrow-left-circle"></i> Trở lại
                                </a>
                                <button type="submit"
                                    class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    style="transition: all 0.3s ease-in-out; border: none;"
                                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(0, 123, 255, 0.3)'"
                                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.2)'">
                                    <i class="bi bi-check-circle"></i> Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

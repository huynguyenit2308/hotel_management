@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container padding-side">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-light rounded-top-4 text-center py-4">
                            <h1 class="mb-0">
                                <i class="bi bi-cash-coin me-2"></i>Quản Lý Giá Dịch Vụ
                            </h1>
                        </div>

                        <div class="card-body p-4 bg-white rounded-bottom-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('service.price.update', ['id' => $service->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="base_price" class="form-label fw-semibold">Giá gốc (VNĐ)</label>
                                    <input type="number" class="form-control rounded-3 shadow-sm" id="base_price"
                                        name="base_price" value="{{ old('base_price', $service->price) }}" required
                                        min="0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Điều chỉnh giá</label>
                                    <div class="input-group">
                                        <select name="adjust_type" class="form-select rounded-start">
                                            <option value="increase">Tăng</option>
                                            <option value="decrease">Giảm</option>
                                        </select>
                                        <input type="number" name="adjust_percent" class="form-control" placeholder="%"
                                            min="0" max="100" step="0.1" required>
                                        <span class="input-group-text rounded-end">%</span>
                                    </div>
                                </div>
                                <div class="text-end mb-4">
                                    <small class="text-muted">Giá mới sẽ được tính và cập nhật tự động.</small>
                                </div>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('service.detail', ['id' => $service->id]) }}"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-arrow-left-circle"></i> Trở lại chi tiết
                                    </a>
                                    <button type="submit"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out; border: none;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(40, 167, 69, 0.3)'"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(40, 167, 69, 0.2)'">
                                        <i class="bi bi-save"></i> Lưu chỉnh sửa
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

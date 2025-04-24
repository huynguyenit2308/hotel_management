@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container padding-side">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-light rounded-top-4 text-center py-4">
                            <h1 class="mb-0">
                                <i class="bi bi-person-lines-fill me-2"></i>Cập Nhật Khách Hàng
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

                            <form action="{{ route('customers.update', ['id' => $customer->id]) }}" method="POST">
                                @csrf
                                @method('POST')

                                <div class="mb-3">
                                    <label for="full_name" class="form-label fw-semibold">Họ và tên</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" id="full_name"
                                        name="full_name" placeholder="Nhập họ và tên..."
                                        value="{{ old('full_name', $customer->full_name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control rounded-3 shadow-sm" id="email"
                                        name="email" placeholder="Nhập email..."
                                        value="{{ old('email', $customer->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" id="phone"
                                        name="phone" placeholder="Nhập số điện thoại..."
                                        value="{{ old('phone', $customer->phone) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Địa chỉ</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" id="address"
                                        name="address" placeholder="Nhập địa chỉ..."
                                        value="{{ old('address', $customer->address) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="birth_day" class="form-label fw-semibold">Ngày sinh</label>
                                    <input type="date" class="form-control rounded-3 shadow-sm" id="birth_day"
                                        name="birth_day" value="{{ old('birth_day', $customer->birth_day) }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="registration_date" class="form-label fw-semibold">Ngày đăng ký</label>
                                    <input type="date" class="form-control rounded-3 shadow-sm" id="registration_date"
                                        name="registration_date" value="{{ old('registration_date', $customer->registration_date) }}" required>
                                </div>

                                <div class="d-flex gap-3">
                                    <a href="{{ route('customers.detail', ['id' => $customer->id]) }}"
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

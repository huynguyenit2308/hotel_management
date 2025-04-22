@extends('dashboard')


@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h2 class="mb-4 text-center">Đăng Ký Tài Khoản</h2>

      {{-- Hiển thị thông báo thành công sau khi đăng ký --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- Hiển thị lỗi validate --}}
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row g-3">
              <div class="col-md-6">
                <label for="full_name" class="form-label">Họ tên</label>
                <input
                  type="text"
                  class="form-control"
                  id="full_name"
                  name="full_name"
                  value="{{ old('full_name') }}"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  value="{{ old('email') }}"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input
                  type="text"
                  class="form-control"
                  id="phone"
                  name="phone"
                  value="{{ old('phone') }}"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="address" class="form-label">Địa chỉ</label>
                <input
                  type="text"
                  class="form-control"
                  id="address"
                  name="address"
                  value="{{ old('address') }}"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="birth_day" class="form-label">Ngày sinh</label>
                <input
                  type="date"
                  class="form-control"
                  id="birth_day"
                  name="birth_day"
                  value="{{ old('birth_day') }}"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="username"
                  value="{{ old('username') }}"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="password" class="form-label">Mật khẩu</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  name="password"
                  required
                >
              </div>

              <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <input
                  type="password"
                  class="form-control"
                  id="password_confirmation"
                  name="password_confirmation"
                  required
                >
              </div>
            </div>

            <div class="mt-4 text-center">
              <button type="submit" class="btn btn-primary px-5">
                Đăng ký
              </button>
            </div>

            {{-- Link chuyển sang trang đăng nhập --}}
            <div class="text-center mt-3">
              Bạn đã có tài khoản?
              <a href="{{ route('login') }}" class="btn btn-link p-0">Đăng nhập</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
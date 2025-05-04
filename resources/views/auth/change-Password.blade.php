@extends('dashboard')

@section('content')
<div class="container">
    <h2>Đổi mật khẩu</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu mới</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection

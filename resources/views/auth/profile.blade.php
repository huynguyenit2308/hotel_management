@extends('dashboard')

@section('content')
    <div class="container">
        <h2>Thông tin cá nhân</h2>
        <table class="table">
            <tr>
                <th>Username</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td>{{ $customer->full_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $customer->email}}</td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>{{ $customer->phone}}</td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>{{ $customer->address}}</td>
            </tr>
            <tr>
                <th>Ngày sinh</th>
                <td>{{ $customer->birth_day}}</td>
            </tr>
            <tr>
                <th>Ngày sinh</th>
                <td>{{ $customer->birth_day}}</td>
            </tr>
            <tr>
                <th>Ngày đăng ký tài khoản</th>
                <td>{{ $customer->registration_date}}</td>
            </tr>
        </table>

        <a href="{{ route('password.change') }}" class="btn btn-warning">Đổi mật khẩu</a>
    </div>
@endsection
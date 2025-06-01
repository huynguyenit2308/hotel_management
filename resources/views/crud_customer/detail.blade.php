@extends('dashboard')
@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Chi tiết khách hàng</h2>
        <div class="card p-4 shadow-sm">
            <p><strong>Họ tên:</strong> {{ $customer->full_name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $customer->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $customer->address }}</p>
            <p><strong>Ngày sinh:</strong> {{ $customer->birth_day }}</p>
            <p><strong>Ngày đăng ký:</strong> {{ $customer->registration_date }}</p>
            <a href="{{ route('customers.list') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
        </div>
    </div>
@endsection
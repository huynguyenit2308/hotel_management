@extends('dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Danh sách khách hàng</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đăng ký</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->registration_date }}</td>
                        <td>
                            <a href="{{ route('customers.detail', ['id' => $customer->id]) }}"
                                class="btn btn-info btn-sm">Chi tiết</a>
                            <a href="{{ route('customers.delete', ['id' => $customer->id]) }}" class="btn btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">
                                Xóa
                            </a>
                            <a href="#" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('dashboard')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Danh sách khách hàng</h1>

        {{-- Thông báo thành công nếu có --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Form tìm kiếm --}}
        <form action="{{ route('customers.list') }}" method="GET" class="d-flex mb-3 justify-content-center" role="search">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên..."
                    value="{{ request('keyword') }}">
                    <button class="btn btn-outline-secondary" type="submit">Tìm Kiếm</button>
            </div>
        </form>

        {{-- Bảng danh sách khách hàng --}}
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
                        <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->registration_date }}</td>
                        <td>
                            <a href="{{ route('customers.detail', ['id' => $customer->id]) }}" class="btn btn-info btn-sm">Chi
                                tiết</a>
                            <a href="{{ route('customers.delete', ['id' => $customer->id]) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">
                                Xóa
                            </a>
                            <a href="{{ route('customers.edit', ['id' => $customer->id]) }}"
                                class="btn btn-warning btn-sm">Sửa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Phân trang --}}
       @if ($customers->hasPages())
    <ul class="pagination-custom">
        {{-- Nút Previous --}}
        @if ($customers->onFirstPage())
            <li class="disabled"><span>&lsaquo;</span></li>
        @else
            <li><a href="{{ $customers->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
        @endif

        {{-- Các số trang --}}
        @foreach ($customers->links()->elements[0] as $page => $url)
            @if ($page == $customers->currentPage())
                <li class="active"><span>{{ $page }}</span></li>
            @else
                <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Nút Next --}}
        @if ($customers->hasMorePages())
            <li><a href="{{ $customers->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
        @else
            <li class="disabled"><span>&rsaquo;</span></li>
        @endif
    </ul>
@endif
    </div>
@endsection
 {{-- CSS phân trang--}}
<style>
    .pagination-custom {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }

    .pagination-custom li {
        margin: 0 4px;
    }

    .pagination-custom li a,
    .pagination-custom li span {
        display: inline-block;
        padding: 8px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        background-color: #fff;
    }

    .pagination-custom li a:hover {
        background-color: #eee;
    }

    .pagination-custom .active span {
        background-color: #d35400;
        color: #fff;
        font-weight: bold;
        border-color: #d35400;
    }

    .pagination-custom .disabled span {
        color: #999;
        background-color: #f0f0f0;
        pointer-events: none;
    }
</style>
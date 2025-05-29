@extends('dashboard')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Danh sách đánh giá</h1>

        {{-- Thông báo lỗi hoặc thành công --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form tìm kiếm --}}
        <form action="{{ route('ratings.list') }}" method="GET" class="d-flex mb-3 justify-content-center" role="search">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên khách hàng..."
                    value="{{ request('keyword') }}">
                <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
            </div>
        </form>


        {{-- Bảng đánh giá --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên khách hàng</th>
                    <th>Đánh giá</th>
                    <th>Bình luận</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ratings as $rating)
                    <tr>
                        <td>{{ $rating->id }}</td>
                        <td>{{ $rating->customer->full_name }}</td>
                        <td>
                            {{ $rating->rating }}
                            <span class="ms-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="fas fa-star text-secondary"></i>
                                    @endif
                                @endfor
                            </span>
                        </td>
                        <td>{{ $rating->comment }}</td>
                        <td>{{ $rating->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Không có đánh giá nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Hiển thị phân trang trực tiếp trong view --}}
        @if ($ratings->hasPages())
            <ul class="pagination-custom">
                {{-- Nút Previous --}}
                @if ($ratings->onFirstPage())
                    <li class="disabled"><span>&lsaquo;</span></li>
                @else
                    <li><a href="{{ $ratings->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
                @endif

                {{-- Các nút trang --}}
                @foreach ($ratings->links()->elements[0] as $page => $url)
                    @if ($page == $ratings->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Nút Next --}}
                @if ($ratings->hasMorePages())
                    <li><a href="{{ $ratings->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
                @else
                    <li class="disabled"><span>&rsaquo;</span></li>
                @endif
            </ul>
        @endif

    </div>
@endsection
{{-- -CSS phân trang --}}
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
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        text-decoration: none;
        color: #333;
        background-color: #fff;
        font-weight: 500;
    }

    .pagination-custom li a:hover {
        background-color: #eee;
    }

    .pagination-custom .active span {
        background-color: #d35400;
        color: #fff;
        border-color: #d35400;
        font-weight: bold;
    }

    .pagination-custom .disabled span {
        background-color: #f0f0f0;
        color: #999;
        border-color: #ddd;
        pointer-events: none;
    }
</style>
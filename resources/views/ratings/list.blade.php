@extends('dashboard')

@section('content')
    <div class="container">
        <h2>Danh sách đánh giá</h2>

        <!-- Hiển thị thông báo thành công hoặc lỗi -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Bảng hiển thị các đánh giá -->
        <table class="table">
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
                @foreach($ratings as $rating)
                    <tr>
                        <td>{{ $rating->id }}</td>
                        <td>{{ $rating->customer->full_name }}</td>
                        <td>
                            {{ $rating->rating }}
                            <span class="ms-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating->rating)
                                        <i class="fas fa-star text-warning"></i> <!-- Hiển thị sao vàng nếu rating >= $i -->
                                    @else
                                        <i class="fas fa-star"></i> <!-- Hiển thị sao xám nếu rating < $i -->
                                    @endif
                                @endfor
                            </span>
                        </td>
                        <td>{{ $rating->comment }}</td>
                        <td>{{ $rating->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
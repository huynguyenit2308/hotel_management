@extends('dashboard')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Đánh Giá Khách Hàng</h3>

    @foreach($ratings as $rating)
        <div class="border rounded p-3 mb-3 shadow-sm bg-light">
            <strong>{{ $rating->customer->full_name }}</strong>
            <div class="text-warning mb-1">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $rating->rating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <div class="fst-italic">{{ $rating->comment ?? 'Không có bình luận' }}</div>
        </div>
    @endforeach
</div>
@endsection

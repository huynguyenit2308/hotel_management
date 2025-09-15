
@extends('dashboard')

@section('content')
<div class="container">
    <h2>Đánh giá khách sạn</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Hiển thị lỗi từ form -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ratings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="rating">Đánh giá (1-5 sao):</label>
            <input type="number" id="rating" name="rating" class="form-control" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="comment">Bình luận:</label>
            <textarea id="comment" name="comment" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
    </form>
</div>
@endsection
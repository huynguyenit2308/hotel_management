{{-- resources/views/errors/404.blade.php --}}
@extends('dashboard')
@section('content')
<div class="text-center mt-5">
    <!-- <h1>404</h1> -->
    <p>Không tìm thấy trang hoặc phòng bạn yêu cầu.</p>
    <a href="{{ route('rooms.index') }}" class="btn btn-primary">Quay lại danh sách phòng</a>
</div>
@endsection
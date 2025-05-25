{{-- filepath: resources/views/errors/notfound.blade.php --}}
@extends('dashboard')

@section('content')
    <div class="container text-center mt-5">
        <p class="lead">Không tìm thấy nhân viên hoặc trang bạn yêu cầu!</p>
        <a href="{{ route('employees.index') }}" class="btn btn-primary">Quay về danh sách nhân viên</a>
    </div>
@endsection
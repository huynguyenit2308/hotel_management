@extends('dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết phòng</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Số phòng</h5>
                            <p class="h4">{{ $room->room_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Loại phòng</h5>
                            <p class="h4">{{ $room->room_type }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Giá phòng</h5>
                            <p class="h4">{{ number_format($room->price) }} VNĐ</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Trạng thái</h5>
                            <p class="h4">
                                <span class="badge bg-{{ $room->status->status_name == 'Available' ? 'success' : ($room->status->status_name == 'Occupied' ? 'danger' : 'warning') }}">
                                    {{ $room->status->status_name }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Ngày tạo</h5>
                            <p class="h4">{{ $room->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Cập nhật lần cuối</h5>
                            <p class="h4">{{ $room->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Quay lại</a>
                        <div>
                            <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
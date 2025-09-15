@extends('dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="display-4">Danh sách quản lý phòng</h2>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Thêm phòng mới
        </a>
    </div>

    <div id="alert-container" class="position-fixed top-0 start-50 translate-middle-x" style="z-index: 1050; width: 100%; max-width: 500px;"></div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('rooms.index') }}" class="row g-5">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo số phòng..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-bed text-primary"></i>
                        </span>
                        <select name="room_type" class="form-select">
                            <option value="">Tất cả loại phòng</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type }}" {{ request('room_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-info-circle text-primary"></i>
                        </span>
                        <select name="status" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->status_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="padding: 10px 20px 5px 20px;">
                        <i class="fas fa-filter"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($rooms->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            Không tìm thấy phòng nào phù hợp với tiêu chí tìm kiếm.
        </div>
    @else
        <div class="row">
            @foreach($rooms as $room)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-door-open text-primary me-2"></i>
                                    Phòng {{ $room->room_number }}
                                </h5>
                                <span class="badge bg-{{ $room->status->status_name == 'Available' ? 'success' : ($room->status->status_name == 'Occupied' ? 'danger' : 'warning') }}">
                                    {{ $room->status->status_name }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <p class="mb-2">
                                    <i class="fas fa-bed text-primary me-2"></i>
                                    <strong>Loại phòng:</strong> {{ $room->room_type }}
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-money-bill-wave text-primary me-2"></i>
                                    <strong>Giá:</strong> {{ number_format($room->price) }} VNĐ
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <div>
                                    <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-lg">
                    {{-- Previous Page Link --}}
                    @if ($rooms->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $rooms->previousPageUrl() }}" aria-label="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                        @if ($page == $rooms->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($rooms->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $rooms->nextPageUrl() }}" aria-label="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>

@push('scripts')
<script>
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show w-100`;
    alert.style.height = '30px';
    alert.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertContainer.appendChild(alert);
    setTimeout(() => {
        alert.remove();
    }, 3000);
}

@if(session('success'))
    showAlert('{{ session('success') }}');
@endif

@if(session('error'))
    showAlert('{{ session('error') }}', 'danger');
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        showAlert('{{ $error }}', 'danger');
    @endforeach
@endif
</script>
@endpush

@push('styles')
<style>
.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.25rem;
    transition: all 0.3s ease;
}

.page-link:hover {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.page-item.active .page-link {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.65;
}

.page-link i {
    font-size: 0.875rem;
}
</style>
@endpush
@endsection 
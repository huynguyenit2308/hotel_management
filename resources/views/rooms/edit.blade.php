@extends('dashboard')


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chỉnh sửa thông tin phòng</h3>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('rooms.update', $room) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="room_number" class="form-label">Số phòng</label>
                                <input type="text" class="form-control @error('room_number') is-invalid @enderror"
                                    id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}"
                                    required>
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_type" class="form-label">Loại phòng</label>
                                <select class="form-select @error('room_type') is-invalid @enderror" id="room_type"
                                    name="room_type" required>
                                    <option value="">Chọn loại phòng</option>
                                    <option value="Standard"
                                        {{ old('room_type', $room->room_type) == 'Standard' ? 'selected' : '' }}>Standard
                                    </option>
                                    <option value="Deluxe"
                                        {{ old('room_type', $room->room_type) == 'Deluxe' ? 'selected' : '' }}>Deluxe
                                    </option>
                                    <option value="Suite"
                                        {{ old('room_type', $room->room_type) == 'Suite' ? 'selected' : '' }}>Suite</option>
                                </select>
                                @error('room_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label fw-semibold">Giá (VNĐ)</label>
                                <input type="text"
                                    class="form-control rounded-3 shadow-sm @error('price') is-invalid @enderror"
                                    id="price" name="price" placeholder="Nhập giá tiền..."
                                    value="{{ old('price', $room->price) }}">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status_id" class="form-label">Trạng thái</label>
                                <select class="form-select @error('status_id') is-invalid @enderror" id="status_id"
                                    name="status_id" required>
                                    <option value="">Chọn trạng thái</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('status_id', $room->status_id) == $status->id ? 'selected' : '' }}>
                                            {{ $status->status_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--**-->
                            <input type="hidden" name="updated_at" value="{{ $room->updated_at }}">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

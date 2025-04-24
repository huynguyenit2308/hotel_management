@extends('dashboard')

@section('content')
    <main>
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Cập nhật đặt phòng</h3>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary">
                            <svg width="18" height="18" class="me-2">
                                <use xlink:href="#arrow-left"></use>
                            </svg>
                            Quay lại
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <div class="row mt-5">
                    <div class="col-md-6">
                        <form action="{{ route('bookings.update', $booking) }}" method="POST" class="p-4 bg-light rounded-4">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Thông tin khách hàng</label>
                                <div class="p-3 bg-white rounded-3">
                                    <p class="mb-1"><strong>Họ và tên:</strong> {{ $booking->customer->full_name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $booking->customer->email }}</p>
                                    <p class="mb-0"><strong>Số điện thoại:</strong> {{ $booking->customer->phone }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="room_id" class="form-label">Phòng</label>
                                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                    <option value="">Chọn phòng</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_number }} - {{ $room->room_type }} ({{ number_format($room->price, 0, ',', '.') }} VNĐ)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="check_in_date" class="form-label">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" id="check_in_date" class="form-control @error('check_in_date') is-invalid @enderror" value="{{ old('check_in_date', $booking->check_in_date->format('Y-m-d')) }}" required>
                                @error('check_in_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="check_out_date" class="form-label">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" id="check_out_date" class="form-control @error('check_out_date') is-invalid @enderror" value="{{ old('check_out_date', $booking->check_out_date->format('Y-m-d')) }}" required>
                                @error('check_out_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status_name" class="form-label">Trạng thái</label>
                                <div class="p-3 bg-white rounded-3">
                                    <p class="mb-0">
                                        @switch($booking->status_name)
                                            @case('Pending')
                                                <span class="badge bg-warning">Đang chờ</span>
                                                @break
                                            @case('Confirmed')
                                                <span class="badge bg-success">Đã xác nhận</span>
                                                @break
                                            @case('Cancelled')
                                                <span class="badge bg-danger">Đã hủy</span>
                                                @break
                                            @case('Completed')
                                                <span class="badge bg-info">Đã hoàn thành</span>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                <input type="hidden" name="status_name" value="{{ $booking->status_name }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                            <img src="{{ asset('images/room1.jpg') }}" alt="img" class="post-image img-fluid rounded-4">
                            <div class="product-description position-absolute p-5 text-start">
                                <h4 class="display-6 fw-normal text-white">{{ $booking->room->room_type }}</h4>
                                <table>
                                    <tbody>
                                        <tr class="text-white">
                                            <td class="pe-2">Số phòng:</td>
                                            <td>{{ $booking->room->room_number }}</td>
                                        </tr>
                                        <tr class="text-white">
                                            <td class="pe-2">Loại phòng:</td>
                                            <td>{{ $booking->room->room_type }}</td>
                                        </tr>
                                        <tr class="text-white">
                                            <td class="pe-2">Giá:</td>
                                            <td class="price">{{ number_format($booking->room->price, 0, ',', '.') }} VNĐ /Đêm</td>
                                        </tr>
                                        <tr class="text-white">
                                            <td class="pe-2">Dịch vụ:</td>
                                            <td>Wifi, Tivi, Máy lạnh, ...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
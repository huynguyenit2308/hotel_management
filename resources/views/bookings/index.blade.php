@extends('dashboard')

@section('content')
    <main>
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Danh sách đặt phòng</h3>
                    </div>
                    <a href="{{ route('bookings.createDirect') }}" class="btn btn-arrow btn-primary mt-3">
                        <span>Đặt phòng mới<svg width="18" height="18">
                                <use xlink:href="#arrow-right"></use>
                            </svg></span>
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <form action="{{ route('bookings.index') }}" method="GET" class="mt-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email hoặc số điện thoại khách hàng" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>

                <div class="swiper room-swiper mt-5">
                    <div class="swiper-wrapper">
                        @foreach($bookings as $booking)
                            <div class="swiper-slide">
                                <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                                    <img src="images/room1.jpg" alt="img" class="post-image img-fluid rounded-4">
                                    <div class="product-description position-absolute p-5 text-start">
                                        <h4 class="display-6 fw-normal text-white">{{ $booking->room->room_type }}</h4>
                                        <table>
                                            <tbody>
                                                <tr class="text-white">
                                                    <td class="pe-2">Khách hàng:</td>
                                                    <td>{{ $booking->customer->full_name }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Số phòng:</td>
                                                    <td>{{ $booking->room->room_number }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Ngày nhận:</td>
                                                    <td>{{ $booking->check_in_date->format('d/m/Y') }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Ngày trả:</td>
                                                    <td>{{ $booking->check_out_date->format('d/m/Y') }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Trạng thái:</td>
                                                    <td>
                                                        <span class="badge bg-{{ $booking->status_name == 'Confirmed' ? 'success' : ($booking->status_name == 'Cancelled' ? 'danger' : 'warning') }}">
                                                            {{ $booking->status_name }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-flex gap-2 mt-3">
                                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning btn-sm">Cập nhật</a>
                                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn hủy đặt phòng này?')">Hủy</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="room-content text-center mt-3">
                                    <h4 class="display-6 fw-normal">{{ $booking->room->room_type }}</h4>
                                    <p><span class="text-primary fs-4">{{ number_format($booking->room->price, 0, ',', '.') }} VNĐ</span>/Đêm</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination room-pagination position-relative mt-5"></div>
                </div>
            </div>
        </section>
    </main>
@endsection
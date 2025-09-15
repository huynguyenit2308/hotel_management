@extends('dashboard')

@section('content')
    <main>
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Chi tiết đặt phòng</h3>
                        
                    </div>
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary" style="margin-left: 550px;">
                            <svg width="18" height="18" class="me-2">
                                <use xlink:href="#arrow-left"></use>
                            </svg>
                            Quay lại
                        </a>
                    
                    <div>
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning me-2">Cập nhật</a>
                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đặt phòng này?')">Hủy đặt phòng</button>
                        </form>
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
                                            <td class="pe-2">Giá:</td>
                                            <td class="price">{{ number_format($booking->room->price, 0, ',', '.') }} VNĐ /Đêm</td>
                                        </tr>
                                        <tr class="text-white">
                                            <td class="pe-2">Loại:</td>
                                            <td>{{ $booking->room->room_type }}</td>
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
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4">
                            <h4 class="mb-4">Thông tin đặt phòng</h4>
                            <table class="table">
                                <tr>
                                    <th>Mã đặt phòng:</th>
                                    <td>#{{ $booking->id }}</td>
                                </tr>
                                <tr>
                                    <th>Khách hàng:</th>
                                    <td>{{ $booking->customer->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $booking->customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Số điện thoại:</th>
                                    <td>{{ $booking->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày đặt:</th>
                                    <td>{{ $booking->booking_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày nhận phòng:</th>
                                    <td>{{ $booking->check_in_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày trả phòng:</th>
                                    <td>{{ $booking->check_out_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái:</th>
                                    <td>
                                        <span class="badge bg-{{ $booking->status_name == 'Confirmed' ? 'success' : ($booking->status_name == 'Cancelled' ? 'danger' : 'warning') }}">
                                            {{ $booking->status_name }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
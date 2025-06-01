@extends('dashboard')

@section('content')
    <main>
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Đặt phòng trực tiếp</h3>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
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
                        <form action="{{ route('bookings.storeDirect') }}" method="POST" class="p-4 bg-light rounded-4">
                            @csrf
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ và tên</label>
                                <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="room_id" class="form-label">Chọn phòng</label>
                                <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                    <option value="">Chọn phòng</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_number }} - {{ $room->room_type }} ({{ number_format($room->price, 0, ',', '.') }} VNĐ/đêm)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="check_in_date" class="form-label">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" id="check_in_date" class="form-control @error('check_in_date') is-invalid @enderror" value="{{ old('check_in_date') }}" required>
                                @error('check_in_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="check_out_date" class="form-label">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" id="check_out_date" class="form-control @error('check_out_date') is-invalid @enderror" value="{{ old('check_out_date') }}" required>
                                @error('check_out_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đặt phòng</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                            <img src="{{ asset('images/room1.jpg') }}" alt="img" class="post-image img-fluid rounded-4">
                            <div class="product-description position-absolute p-5 text-start">
                                <h4 class="display-6 fw-normal text-white">Thông tin phòng</h4>
                                <table>
                                    <tbody>
                                        <tr class="text-white">
                                            <td class="pe-2">Số phòng:</td>
                                            <td id="room-number">-</td>
                                        </tr>
                                        <tr class="text-white">
                                            <td class="pe-2">Loại phòng:</td>
                                            <td id="room-type">-</td>
                                        </tr>
                                        <tr class="text-white">
                                            <td class="pe-2">Giá:</td>
                                            <td id="room-price" class="price">-</td>
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

    @push('scripts')
    <script>
        document.getElementById('room_id').addEventListener('change', function() {
            const roomId = this.value;
            if (roomId) {
                const room = @json($rooms->keyBy('id')->toArray())[roomId];
                document.getElementById('room-number').textContent = room.room_number;
                document.getElementById('room-type').textContent = room.room_type;
                document.getElementById('room-price').textContent = new Intl.NumberFormat('vi-VN').format(room.price) + ' VNĐ /Đêm';
            } else {
                document.getElementById('room-number').textContent = '-';
                document.getElementById('room-type').textContent = '-';
                document.getElementById('room-price').textContent = '-';
            }
        });
    </script>
    @endpush
@endsection
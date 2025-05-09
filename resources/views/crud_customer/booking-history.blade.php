@extends('dashboard')

@section('content')
<div class="container">
    <h2 class="text-center">Lịch sử đặt phòng</h2>

    @if ($bookings->isEmpty())
        <p class="text-center">Bạn chưa có lịch sử đặt phòng.</p>
    @else
        <table class="table table-bordered mx-auto">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Phòng</th>
                    <th>Ngày nhận</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->room_id }}</td>
                        <td>{{ $booking->check_in_date }}</td>
                        <td>{{ $booking->check_out_date }}</td>
                        <td>{{ $booking->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
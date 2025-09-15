@extends('dashboard')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4">Thống kê dịch vụ đã sử dụng</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-danger">
                    <tr>
                        <th scope="col">Tên dịch vụ</th>
                        <th scope="col">Tổng số lượng</th>
                        <th scope="col">Tổng doanh thu (VNĐ)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statistic as $value)
                        <tr>
                            <td>{{ $value->service_name }}</td>
                            <td>{{ $value->total_quantity }}</td>
                            <td>{{ number_format($value->total_amount) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex pt-3 mb-4">
            <a href="{{ route('service.list') }}"
                class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm transition-all"
                style="transition: all 0.3s ease-in-out;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)'"
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                <span>Trở lại danh sách</span>
            </a>
        </div>
    </div>
@endsection

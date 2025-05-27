@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="card shadow rounded-4 p-4">
                        <h1 class="text-center mb-4">Chi tiết hóa đơn</h1>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded-4 shadow-sm h-100">
                                    <p class="mb-3">
                                        <i class="bi bi-tag-fill me-2 text-primary"></i>
                                        <strong>Dịch vụ:</strong>
                                        @php
                                            $servicesCount = $invoice->services->groupBy('service_name');
                                        @endphp
                                        @foreach ($servicesCount as $serviceName => $services)
                                            {{ count($services) > 1 ? count($services) . ' ' . $serviceName : $serviceName }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </p>
                                    <p class="mb-3">
                                        <i class="bi bi-currency-dollar me-2 text-success"></i>
                                        <strong>Giá:</strong>
                                        {{ number_format($invoice->total_amount, 0, ',', '.') }} VNĐ
                                    </p>
                                    <p class="mb-3">
                                        <i class="bi bi-calendar-event me-2 text-warning"></i>
                                        <strong>Ngày đặt:</strong>
                                        {{ \Carbon\Carbon::parse($invoice->create_at)->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="mb-3">
                                        <i class="bi bi-calendar-event me-2 text-warning"></i>
                                        <strong>Thanh toán vào:</strong>
                                        {{ \Carbon\Carbon::parse($invoice->created_at)->format('H:i d/m/Y') }}
                                    </p>
                                    <p class="mb-3">
                                        <i class="bi bi-calendar-event me-2 text-warning"></i>
                                        <strong>Phương thức:</strong>
                                        @if ($invoice->payment_method === 'cash')
                                            Thanh toán tiền mặt
                                        @elseif ($invoice->payment_method === 'online')
                                            Thanh toán online
                                        @else
                                            Không xác định
                                        @endif
                                    </p>
                                    <p class="mb-3">
                                        <i class="bi bi-check-circle-fill me-2 text-info"></i>
                                        <strong>Trạng thái:</strong>
                                        <span
                                            class="badge
                                            @if ($invoice->status === 'Pending') bg-warning text-dark
                                            @elseif ($invoice->status === 'Paid') bg-success
                                            @elseif ($invoice->status === 'Cancel') bg-danger
                                            @else bg-secondary @endif">
                                            {{ $invoice->status }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6 text-center">
                                @if ($invoice->services->first()->image)
                                    <img src="{{ asset('storage/' . $invoice->services->first()->image) }}"
                                        alt="Ảnh dịch vụ"
                                        onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';"
                                        class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 250px;">
                                @else
                                    <img src="{{ asset('images/default.jpg') }}" alt="Ảnh mặc định"
                                        class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 250px;">
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('invoice.list') }}"
                                class="btn btn-primary rounded-4 w-50 d-flex align-items-center justify-content-center gap-2 shadow-sm py-2 px-3"
                                style="transition: all 0.3s ease-in-out;" onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'">
                                <i class="bi bi-arrow-left-circle"></i> Trở lại danh sách
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

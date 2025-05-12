@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="text-center display-4 fw-normal mb-5">Danh sách hóa đơn đang chờ xác nhận</h2>

            @if ($invoices->count() > 0)
                <form action="{{ route('invoice.payment') }}" method="POST" id="paymentForm">
                    @if (session('success'))
                        <div class="alert alert-success text-center d-flex justify-content-between align-items-center">
                            <span>{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center d-flex justify-content-between align-items-center">
                            <span>{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @csrf

                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <label class="form-check-label me-2" for="selectAll">Chọn tất cả</label>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                    </div>

                    <div class="list-group">
                        @foreach ($invoices as $invoice)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class=" d-flex align-items-start gap-5">
                                    <div style="flex-shrink: 0;">
                                        @if ($invoice->service->image)
                                            <img src="{{ asset('storage/' . $invoice->service->image) }}" alt="Ảnh dịch vụ"
                                                class="img-fluid rounded-3 shadow-sm"
                                                style="width: 170px; height: 170px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="Không có ảnh"
                                                class="img-fluid rounded-3 shadow-sm"
                                                style="width: 170px; height: 170px; object-fit: cover;">
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <h3 class="mb-2 fw-bold">{{ $invoice->service->service_name }}</h3>
                                        <p class="mb-1">Giá:
                                            <span class="fw-bold">{{ number_format($invoice->service->price, 0, ',', '.') }}
                                                VND</span>
                                        </p>
                                        <p class="mb-1">Ngày đặt:
                                            {{ \Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y H:i') }}</p>
                                        <p class="mb-1">Ghi chú: {{ $invoice->note ?? 'Không có ghi chú' }}</p>
                                        <span class="badge bg-warning">{{ ucfirst($invoice->status) }}</span>
                                    </div>
                                <div>
                                    <h3 class="mb-2 fw-bold">{{ $invoice->service->service_name }}</h3>
                                    <p class="mt-2 mb-0">Giá: <span
                                            class="fw-bold">{{ number_format($invoice->service->price, 0, ',', '.') }}
                                            VND</span></p>
                                    <p class="mb-1">Ngày đặt:
                                        {{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i') }}</p>
                                    <p class="mb-1">Ghi chú: {{ $invoice->note ?? 'Không có ghi chú' }}</p>
                                    <span class="badge bg-warning">{{ ucfirst($invoice->status) }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-2 px-2 py-1 rounded" style="min-width: 130px;">
                                    <button type="button"
                                        class="btn btn-primary rounded-4 d-flex align-items-center justify-content-center gap-2 shadow-sm py-2 px-3"
                                        data-bs-toggle="modal" data-bs-target="#cancelModal{{ $invoice->id }}"
                                        style="transition: all 0.3s ease-in-out;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-trash3-fill"></i> Hủy
                                    </button>

                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="invoice_ids[]"
                                            value="{{ $invoice->id }}" id="invoice{{ $invoice->id }}"
                                            data-price="{{ $invoice->service->price }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="selectedSummary" class="mt-3 text-end align-items-center"></div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}"
                            class="py-3 btn btn-primary rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                            style="transition: all 0.3s ease-in-out; flex-basis: 30%; padding: 5px 15px; font-size: 14px;"
                            onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-arrow-left-circle"></i> Trở lại
                        </a>
                        <button type="submit"
                            class="py-3 btn btn-primary rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                            style="transition: all 0.3s ease-in-out; border: none; flex-basis: 30%; padding: 5px 15px; font-size: 14px;"
                            onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(0, 123, 255, 0.3)'"
                            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.2)'">
                            <i class="bi bi-check-circle"></i>Thanh toán
                        </button>
                    </div>

                </form>

                @foreach ($invoices as $invoice)
                    <div class="modal fade" id="cancelModal{{ $invoice->id }}" tabindex="-1"
                        aria-labelledby="cancelModalLabel{{ $invoice->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow">
                                <div class="modal-header bg-danger-subtle text-light rounded-top-4">
                                    <h3 class="modal-title" id="cancelModalLabel{{ $invoice->id }}">Xác nhận hủy</h3>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn hủy dịch vụ
                                    <strong>{{ $invoice->service->service_name }}</strong>?
                                </div>
                                <div class="modal-footer d-flex gap-2 justify-content-end">
                                    <form action="{{ route('invoice.cancel.user', ['id' => $invoice->id]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="btn bg-danger text-light rounded-pill d-flex align-items-center shadow-sm px-4 py-2"
                                            style="transition: all 0.3s ease-in-out;"
                                            onmouseover="this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                            <i class="bi bi-trash3-fill"></i> Xác nhận
                                        </button>
                                    </form>
                                    <button type="button"
                                        class="btn btn-secondary rounded-pill d-flex align-items-center shadow-sm px-4 py-2"
                                        data-bs-dismiss="modal" onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-x-circle-fill"></i> Hủy
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">Bạn chưa có hóa đơn nào đang chờ xác nhận.</p>
            @endif
        </div>
    </section>
@endsection

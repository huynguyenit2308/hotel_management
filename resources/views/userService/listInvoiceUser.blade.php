@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="text-center display-4 fw-normal mb-5">
                Danh sách hóa đơn đang chờ xác nhận
            </h2>
            @if ($invoices->count() > 0)
                <form action="#" method="POST">
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
                                <div>
                                    <h3 class="mb-2 fw-bold">{{ $invoice->service->service_name }}</h3>
                                    <p class="mt-2 mb-0">Giá:
                                        <span class="fw-bold">{{ number_format($invoice->service->price, 0, ',', '.') }}
                                            VND</span>
                                    </p>
                                    <p class="mb-1">Ngày đặt:
                                        {{ \Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y H:i') }}</p>
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

                            <div class="modal fade" id="cancelModal{{ $invoice->id }}" tabindex="-1"
                                aria-labelledby="cancelModalLabel{{ $invoice->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-header bg-danger-subtle text-light rounded-top-4">
                                            <h3 class="modal-title" id="cancelModalLabel{{ $invoice->id }}">Xác nhận hủy
                                            </h3>
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
                                                @method('GET')
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
                    </div>
                    <div id="selectedSummary" class="mt-3 text-end align-items-center"></div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit"
                            class="btn btn-primary rounded-4 d-flex align-items-center justify-content-center gap-2 shadow-sm py-2 px-4"
                            style="transition: all 0.3s ease-in-out;" onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <i class="bi bi-credit-card"></i>
                            Xác nhận thanh toán
                        </button>
                    </div>
                </form>
            @else
                <p class="text-center">Bạn chưa có hóa đơn nào đang chờ xác nhận.</p>
            @endif
        </div>
    </section>
@endsection

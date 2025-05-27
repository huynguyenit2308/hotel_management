@extends('dashboard')

@section('content')
    <div class="container py-5">
        <h2 class="text-center display-4 fw-normal mb-5">Danh sách hóa đơn thanh toán</h2>
        @if (session('error'))
            <div id="alert-error" class="alert alert-danger text-center d-flex justify-content-between align-items-center">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="mb-4">
            <ul class="list-group">
                @foreach ($invoices as $invoice)
                    <li class="list-group-item">
                        <div class="d-flex align-items-start gap-5">
                            <div style="flex-shrink: 0;">
                                @if ($invoice->service->image)
                                    <img src="{{ asset('storage/' . $invoice->service->image) }}"
                                        alt="{{ $invoice->service->service_name }}"
                                        onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';"
                                        class="img-fluid rounded-3 shadow-sm"
                                        style="width: 220px; height: 220px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" alt="Không có ảnh"
                                        class="img-fluid rounded-3 shadow-sm"
                                        style="width: 220px; height: 220px; object-fit: cover;">
                                @endif
                            </div>
                            <div>

                                <h2 class="fw-bold">{{ $invoice->service->service_name }}</h2>
                                <p>Ngày đặt:
                                    <strong> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i') }}</strong>
                                </p>
                                <p>Ngày sử dụng:
                                    <strong>{{ \Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y H:i') }}</strong>
                                </p>
                                <p>Giá dịch vụ:<strong> {{ number_format($invoice->service->price, 0, ',', '.') }}
                                        VND</strong></p>
                                <p>Ghi chú: {{ $invoice->note ?? 'Không có ghi chú' }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <form method="GET" action="{{ route('invoice.payment') }}">
            @foreach ($invoices as $invoice)
                <input type="hidden" name="invoice_ids[]" value="{{ $invoice->id }}">
            @endforeach
            <select name="voucher_code" class="form-select" onchange="this.form.submit()">
                <option value="">-- Chọn voucher --</option>
                @foreach ($vouchers as $voucher)
                    <option value="{{ $voucher->code }}" {{ $voucher->code == $voucherCode ? 'selected' : '' }}>
                        {{ $voucher->code }} -
                        {{ $voucher->type === 'percent' ? $voucher->value . '%' : number_format($voucher->value, 0, ',', '.') . ' VND' }}
                        - <span class="badge bg-info">Còn {{ $voucher->usage_limit - $voucher->used_count }} lần sử
                            dụng</span>
                    </option>
                @endforeach
            </select>
        </form>
        <div class="my-3 text-end">
            <p><strong>Tổng tiền:</strong> {{ number_format($originalTotal, 0, ',', '.') }} VND</p>
            @if ($discount > 0)
                <p class="text-success"><strong>Giảm giá:</strong> -{{ number_format($discount, 0, ',', '.') }} VND</p>
            @endif
            <p><strong>Thành tiền:</strong> {{ number_format($totalAmount, 0, ',', '.') }} VND</p>
        </div>

        <form action="{{ route('payment.cash.online') }}" method="POST">
            @csrf
            <input type="hidden" name="voucher_code" value="{{ $voucherCode }}">
            @foreach ($invoices as $invoice)
                <input type="hidden" name="invoice_ids[]" value="{{ $invoice->id }}">
            @endforeach
            <h4>Chọn phương thức thanh toán:</h4>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="cash" id="cash" checked>
                <label class="form-check-label" for="cash">
                    Thanh toán tiền mặt
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="online" id="online">
                <label class="form-check-label" for="online">
                    Thanh toán online (VNPay, Momo...)
                </label>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('invoice.list.user') }}"
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
                    <i class="bi bi-check-circle"></i> Xác nhận thanh toán
                </button>
            </div>
        </form>
    </div>
@endsection

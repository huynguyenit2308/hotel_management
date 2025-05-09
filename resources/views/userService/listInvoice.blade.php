@extends('dashboard')

@section('content')
    <main class="py-5">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center display-4 fw-normal mb-5">Danh sách hóa đơn</h2>
            @if ($invoices->count())
                <div class="row g-4 justify-content-center">
                    @foreach ($invoices as $invoice)
                        <div class="col-md-6 col-xl-4">
                            <div
                                class="service mb-2 text-center rounded-4 p-4 shadow-sm d-flex flex-column justify-content-between h-100">
                                <div>
                                    <h4 class="display-6 fw-normal my-3">
                                        {{ $invoice->service->service_name }}
                                    </h4>
                                    <span
                                        class="badge 
                                    @if ($invoice->status === 'pending') bg-warning text-dark 
                                    @elseif($invoice->status === 'confirmed') bg-success 
                                    @else bg-danger @endif mt-2">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('invoice.detail', ['id' => $invoice->id]) }}" class="btn btn-arrow">
                                        <span class="text-decoration-underline">
                                            Xem chi tiết
                                            <svg width="18" height="18">
                                                <use xlink:href="#arrow-right"></use>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center mt-4">
                        <div class="pagination-wrapper">
                            {{ $invoices->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center">
                    Không có hóa đơn nào!
                </div>
            @endif
        </div>
    </main>
@endsection

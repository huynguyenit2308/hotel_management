@extends('dashboard')

@section('content')
    <style>
        .suggestion-item:hover {
            background-color: #EAE5DD;
        }
    </style>
    <section id="vouchers" class="py-5">
        <div class="container-fluid padding-side" data-aos="fade-up">
            <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">Danh sách voucher</h3>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger shadow-sm" id="error-alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-3">
                    <a href="{{route('voucher.store')}}"
                        class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm transition-all"
                        style="transition: all 0.3s ease-in-out;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)'"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                        <span>Thêm Voucher</span>
                    </a>
                </div>
            </div>

            <div class="row mt-5 justify-content-center">
                @if ($voucher->isEmpty())
                    <div class="col-12 text-center">
                        <p>Không có Voucher nào!</p>
                    </div>
                @else
                    @foreach ($voucher as $value)
                        <div class="col-md-6 col-xl-4">
                            <div class="service mb-4 text-center rounded-4 p-5">
                                <h4 class="display-6 fw-normal my-3">{{ $value->code }}</h4>
                                <a href="{{ route('voucher.detail', ['id' => $value->encoded_id]) }}" class="btn btn-arrow">
                                    <span class="text-decoration-underline">
                                        Xem chi tiết
                                        <svg width="18" height="18">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <div class="pagination-wrapper">
                {{ $voucher->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
@endsection

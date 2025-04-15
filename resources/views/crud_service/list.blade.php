@if (session('error'))
    <div class="alert alert-danger shadow-sm" id="error-alert">
        {{ session('error') }}
    </div>
@endif
@extends('dashboard')

@section('content')
    <section id="services" class="py-5">
        <div class="container-fluid padding-side" data-aos="fade-up">
            <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">Danh sách dịch vụ</h3>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="{{ route('service.search') }}" method="GET" class="position-relative">
                    <input type="text" name="keyword" class="form-control bg-secondary border-0 rounded-5 px-4 py-2"
                        placeholder="Tìm kiếm dịch vụ..." value="{{ request('keyword') }}">
                    <button type="submit"
                        class="position-absolute top-50 end-0 translate-middle-y p-1 me-3 border-0 bg-transparent">
                        <svg width="20" height="20">
                            <use xlink:href="#search"></use>
                        </svg>
                    </button>
                </form>
                <div class="d-flex gap-3">
                    <a href="{{ route('service.statistic') }}"
                        class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm transition-all"
                        style="transition: all 0.3s ease-in-out;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)'"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                        <span>Thống kê dịch vụ</span>
                    </a>
                    <a href="{{ route('service.add') }}"
                        class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm transition-all"
                        style="transition: all 0.3s ease-in-out;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)'"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                        <span>Thêm Dịch Vụ</span>
                    </a>
                </div>
            </div>

            <div class="row mt-5 justify-content-center">
                @foreach ($service as $value)
                    <div class="col-md-6 col-xl-4">
                        <div class="service mb-4 text-center rounded-4 p-5">
                            <h4 class="display-6 fw-normal my-3">{{ $value->service_name }}</h4>
                            <a href="{{ route('service.detail', ['id' => $value->id]) }}" class="btn btn-arrow">
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
            </div>
        </div>
    </section>
@endsection

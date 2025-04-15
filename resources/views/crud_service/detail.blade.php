@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="card shadow rounded-4 p-4">
                        <h1 class="text-center">Chi tiết dịch vụ {{ $service->service_name }}</h1>
                        <p><strong>Tên:</strong> {{ $service->service_name }}</p>
                        <p><strong>Giá:</strong> {{ number_format($service->price, 0, ',', '.') }} VNĐ</p>
                        <p><strong>Mô tả:</strong> {{ $service->description }}</p>
                        <div class="row mt-4">
                            <div class="col-6 d-flex gap-2">
                                <a href="#"
                                    class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    style="transition: all 0.3s ease-in-out;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="bi bi-pencil-square"></i> Sửa dịch vụ
                                </a>

                                <form action="#" method="POST"
                                    class="flex-fill">
                                    <button type="button"
                                        class="btn btn-primary rounded-pill w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal">
                                        <i class="bi bi-trash3-fill"></i> Xóa dịch vụ
                                    </button>
                                </form>
                            </div>

                            <div class="col-6">
                                <a href="{{ route('service.list') }}"
                                    class="btn btn-primary rounded-pill w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    style="transition: all 0.3s ease-in-out;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="bi bi-arrow-left-circle"></i> Trở lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

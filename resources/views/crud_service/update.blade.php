@extends('dashboard')

@section('content')
    <section class="py-5">
        <div class="container padding-side">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-light rounded-top-4 text-center py-4">
                            <h1 class="mb-0">
                                <i class="bi bi-pencil-square me-2"></i>Cập Nhật Dịch Vụ
                            </h1>
                        </div>

                        <div class="card-body p-4 bg-white rounded-bottom-4">
                            <form action="{{ route('service.update', ['id' => $service->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="service_name" class="form-label fw-semibold">Tên dịch vụ</label>
                                    <input type="text"
                                        class="form-control rounded-3 shadow-sm @error('service_name') is-invalid @enderror"
                                        id="service_name" name="service_name" placeholder="Nhập tên dịch vụ..."
                                        value="{{ old('service_name', $service->service_name) }}">
                                    @error('service_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label fw-semibold">Giá (VNĐ)</label>
                                    <input type="text"
                                        class="form-control rounded-3 shadow-sm @error('price') is-invalid @enderror"
                                        id="price" name="price" placeholder="Nhập giá tiền..."
                                        value="{{ old('price', $service->price) }}">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <label for="image" class="form-label fw-semibold">Chọn ảnh mới (nếu muốn
                                    thay)</label>
                                <div class="mb-4">
                                    <input type="file"
                                        class="form-control rounded-3 shadow-sm @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*" onchange="updateImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 text-center">
                                    @if ($service->image)
                                        <img id="update" src="{{ asset('storage/' . $service->image) }}"
                                            alt="Ảnh dịch vụ" class="img-fluid rounded-3 shadow-sm mb-2 d-inline-block"
                                            style="max-height: 250px;">
                                    @else
                                        <p>Không có ảnh</p>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label fw-semibold">Mô tả</label>
                                    <textarea class="form-control rounded-3 shadow-sm @error('description') is-invalid @enderror" id="description"
                                        name="description" rows="4" placeholder="Nhập mô tả dịch vụ...">{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-3">
                                    <a href="{{ route('service.detail', ['id' => $service->id]) }}"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-arrow-left-circle"></i> Trở lại chi tiết
                                    </a>
                                    <button type="submit"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out; border: none;"
                                        onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(40, 167, 69, 0.3)'"
                                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(40, 167, 69, 0.2)'">
                                        <i class="bi bi-save"></i> Lưu chỉnh sửa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('dashboard')

@section('content')
    <main class="py-5">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center display-4 mb-4">Đặt Dịch Vụ</h2>

            <div class="row align-items-stretch">
                <div class="col-md-6 d-flex">
                    <div class="card shadow rounded-4 p-4 w-100">
                        <form action="{{ route('post.booking.service') }}" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Dịch vụ</label>
                                <input type="text" class="form-control" value="{{ $service->service_name }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label fw-bold">Ngày sử dụng</label>
                                <input type="date" name="date" id="date"
                                    class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}">
                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="time" class="form-label fw-bold">Giờ sử dụng</label>
                                <input type="time" name="time" id="time"
                                    class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}">
                                @error('time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Ghi chú (tuỳ chọn)</label>
                                <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex gap-3">
                                <a href="{{ route('home') }}"
                                    class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    style="transition: all 0.3s ease-in-out;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="bi bi-arrow-left-circle"></i> Trở lại
                                </a>
                                <button type="submit"
                                    class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                    style="transition: all 0.3s ease-in-out; border: none;"
                                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(0, 123, 255, 0.3)'"
                                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.2)'">
                                    <i class="bi bi-check-circle"></i> Đặt Dịch Vụ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="Image"
                        class="img-fluid rounded-4 object-fit-cover w-100 h-100">
                </div>
            </div>
        </div>
    </main>
@endsection

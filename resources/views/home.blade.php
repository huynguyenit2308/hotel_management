@extends('dashboard')

@section('content')
    <main>
        <section id="slider" data-aos="fade-up">
            <div class="container-fluid padding-side">
                <div class="d-flex rounded-5"
                    style="background-image: url(images/slider-image.jpg); background-size: cover; background-repeat: no-repeat; height: 85vh; background-position: center;">
                    <div class="row align-items-center m-auto pt-5 px-4 px-lg-0">
                        <div class="text-start col-md-6 col-lg-5 col-xl-6 offset-lg-1">
                            <h2 class="display-1 fw-normal">Cánh cổng vào sự yên bình của bạn.</h2>
                            <a href="#" class="btn btn-arrow btn-primary mt-3">
                                <span>Khám phá phòng <svg width="18" height="18">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about-us" class="padding-large">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">Khách sạn TDC: Cánh cổng dẫn đến sự yên
                    bình
                </h3>
                <div class="row align-items-start mt-3 mt-lg-5">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <p>Chào mừng đến với Khách sạn TDC, nơi sự thoải mái hòa quyện với sự yên tĩnh. Tọa lạc tại
                                trung
                                tâm của một
                                thành phố nhộn nhịp, khách sạn của chúng tôi mang đến nơi nghỉ dưỡng yên bình cho cả khách
                                du lịch công
                                tác và giải trí. Với các tiện nghi hiện đại và bầu không khí ấm áp, hấp dẫn, chúng tôi nỗ
                                lực để mang đến
                                cho bạn kỳ nghỉ tuyệt vời cùng chúng tôi.</p>
                            <a href="#" class="btn btn-arrow btn-primary mt-3">
                                <span>Đặt phòng ngay <svg width="18" height="18">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></span>
                            </a>
                        </div>
                        <img src="images/about-img1.jpg" alt="img" class="img-fluid rounded-4 mt-4">
                    </div>
                    <div class="col-lg-6 mt-5 mt-lg-0">
                        <img src="images/about-img2.jpg" alt="img" class="img-fluid rounded-4">
                        <img src="images/about-img3.jpg" alt="img" class="img-fluid rounded-4 mt-4">
                    </div>
                </div>
            </div>
        </section>

        <section id="info">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-3 text-center mb-4 mb-lg-0">
                        <h3 class="display-1 fw-normal text-primary position-relative">100 <span
                                class="position-absolute top-50 end-50 translate-middle z-n1 ps-lg-4 pt-lg-4"><img
                                    src="images/pattern1.png" alt="pattern" class="img-fluid"></span></h3>
                        <p class="text-capitalize">Khách hàng hài lòng</p>
                    </div>
                    <div class="col-md-3 text-center mb-4 mb-lg-0">
                        <h3 class="display-1 fw-normal text-primary position-relative">6 <span
                                class="position-absolute top-50 translate-middle z-n1"><img src="images/pattern1.png"
                                    alt="pattern" class="img-fluid"></span></h3>
                        <p class="text-capitalize">Phòng</p>
                    </div>
                    <div class="col-md-3 text-center mb-4 mb-lg-0">
                        <h3 class="display-1 fw-normal text-primary position-relative">30 <span
                                class="position-absolute top-100 pb-5 translate-middle z-n1"><img src="images/pattern1.png"
                                    alt="pattern" class="img-fluid"></span></h3>
                        <p class="text-capitalize">Dịch vụ</p>
                    </div>
                    <div class="col-md-3 text-center mb-4 mb-lg-0">
                        <h3 class="display-1 fw-normal text-primary position-relative">10 <span
                                class="position-absolute top-50 end-50 pb-lg-4 pe-lg-2 translate-middle z-n1"><img
                                    src="images/pattern1.png" alt="pattern" class="img-fluid"></span></h3>
                        <p class="text-capitalize">Nhân viên</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Khám phá phòng của chúng tôi</h3>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="{{ route('bookings.createDirect') }}" class="btn btn-arrow btn-primary mt-3">
                            <span>Đặt phòng trực tiếp<svg width="18" height="18">
                                <use xlink:href="#arrow-right"></use>
                            </svg></span>
                        </a>
                        <a href="#" class="btn btn-arrow btn-primary mt-3">
                            <span>Khám phá phòng<svg width="18" height="18">
                                <use xlink:href="#arrow-right"></use>
                            </svg></span>
                        </a>
                    </div>
                </div>

                <div class="swiper room-swiper mt-5">
                    <div class="swiper-wrapper">
                        @foreach ($rooms as $room)
                            <div class="swiper-slide">
                                <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                                    <img src="images/room1.jpg" alt="img" class="post-image img-fluid rounded-4">
                                    <div class="product-description position-absolute p-5 text-start">
                                        <h4 class="display-6 fw-normal text-white">{{ $room->room_type }}</h4>
                                        <table>
                                            <tbody>
                                                <tr class="text-white">
                                                    <td class="pe-2">Giá:</td>
                                                    <td class="price">{{ number_format($room->price, 0, ',', '.') }} VNĐ /Đêm</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Loại:</td>
                                                    <td>{{ $room->room_type }}</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Dịch vụ:</td>
                                                    <td>Wifi, Tivi, Máy lạnh,Tủ lạnh...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}">
                                            <p class="text-decoration-underline text-white m-0 mt-2">Đặt ngay</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="room-content text-center mt-3">
                                    <h4 class="display-6 fw-normal"><a href="#">{{ $room->room_type }}</a></h4>
                                    <p><span class="text-primary fs-4">{{ number_format($room->price, 0, ',', '.') }} VNĐ</span>/Đêm</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination room-pagination position-relative mt-5"></div>
                </div>
            </div>
        </section>

        <section id="services" class="pb-5">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <h3 class="display-3 text-center fw-normal col-lg-4 offset-lg-4">Khám phá dịch vụ</h3>
                <div class="row mt-5">
                    <div class="col-md-6 col-xl-4">
                        <div class="service mb-4 text-center rounded-4 p-5">
                            <h4 class="display-6 fw-normal my-3">Yoga</h4>
                            <a href="#" class="btn btn-arrow">
                                <span class="text-decoration-underline">Sử dụng ngay<svg width="18" height="18">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

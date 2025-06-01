<?php $__env->startSection('content'); ?>
    <main>
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Danh sách đặt phòng</h3>
                    </div>
                    <a href="<?php echo e(route('bookings.createDirect')); ?>" class="btn btn-arrow btn-primary mt-3">
                        <span>Đặt phòng mới<svg width="18" height="18">
                                <use xlink:href="#arrow-right"></use>
                            </svg></span>
                    </a>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success mt-3"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="alert alert-danger mt-3"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <form action="<?php echo e(route('bookings.index')); ?>" method="GET" class="mt-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email hoặc số điện thoại khách hàng" value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>

                <div class="swiper room-swiper mt-5">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                                    <img src="images/room1.jpg" alt="img" class="post-image img-fluid rounded-4">
                                    <div class="product-description position-absolute p-5 text-start">
                                        <h4 class="display-6 fw-normal text-white"><?php echo e($booking->room->room_type); ?></h4>
                                        <table>
                                            <tbody>
                                                <tr class="text-white">
                                                    <td class="pe-2">Khách hàng:</td>
                                                    <td><?php echo e($booking->customer->full_name); ?></td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Số phòng:</td>
                                                    <td><?php echo e($booking->room->room_number); ?></td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Ngày nhận:</td>
                                                    <td><?php echo e($booking->check_in_date->format('d/m/Y')); ?></td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Ngày trả:</td>
                                                    <td><?php echo e($booking->check_out_date->format('d/m/Y')); ?></td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Trạng thái:</td>
                                                    <td>
                                                        <span class="badge bg-<?php echo e($booking->status_name == 'Confirmed' ? 'success' : ($booking->status_name == 'Cancelled' ? 'danger' : 'warning')); ?>">
                                                            <?php echo e($booking->status_name); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="d-flex gap-2 mt-3">
                                            <a href="<?php echo e(route('bookings.show', $booking)); ?>" class="btn btn-primary btn-sm">Chi tiết</a>
                                            <a href="<?php echo e(route('bookings.edit', $booking)); ?>" class="btn btn-warning btn-sm">Cập nhật</a>
                                            <form action="<?php echo e(route('bookings.destroy', $booking)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn hủy đặt phòng này?')">Hủy</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="room-content text-center mt-3">
                                    <h4 class="display-6 fw-normal"><?php echo e($booking->room->room_type); ?></h4>
                                    <p><span class="text-primary fs-4"><?php echo e(number_format($booking->room->price, 0, ',', '.')); ?> VNĐ</span>/Đêm</p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="swiper-pagination room-pagination position-relative mt-5"></div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/bookings/index.blade.php ENDPATH**/ ?>
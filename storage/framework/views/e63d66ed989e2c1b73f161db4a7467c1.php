<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="text-center">Lịch sử đặt phòng</h2>

    <?php if($bookings->isEmpty()): ?>
        <p class="text-center">Bạn chưa có lịch sử đặt phòng.</p>
    <?php else: ?>
        <table class="table table-bordered mx-auto">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Phòng</th>
                    <th>Ngày nhận</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái</th>
                    <th>Đánh giá</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($booking->id); ?></td>
                        <td><?php echo e($booking->room_id); ?></td>
                        <td><?php echo e($booking->check_in_date); ?></td>
                        <td><?php echo e($booking->check_out_date); ?></td>
                        <td><?php echo e($booking->status); ?></td>
                        <td> <a href="<?php echo e(route('ratings.create', ['booking_id' => $booking->id])); ?>" class="btn btn-sm btn-primary">
                    Đánh giá
                </a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/crud_customer/booking-history.blade.php ENDPATH**/ ?>
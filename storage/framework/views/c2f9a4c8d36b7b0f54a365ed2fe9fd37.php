<?php $__env->startSection('content'); ?>
<div class="text-center mt-5">
    <!-- <h1>404</h1> -->
    <p>Không tìm thấy trang hoặc phòng bạn yêu cầu.</p>
    <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-primary">Quay lại danh sách phòng</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/errors/404.blade.php ENDPATH**/ ?>
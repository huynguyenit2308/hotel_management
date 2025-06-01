<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Thông tin cá nhân</h2>
        <table class="table">
            <tr>
                <th>Username</th>
                <td><?php echo e($user->username); ?></td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td><?php echo e($customer->full_name); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo e($customer->email); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?php echo e($customer->phone); ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?php echo e($customer->address); ?></td>
            </tr>
            <tr>
                <th>Ngày sinh</th>
                <td><?php echo e($customer->birth_day); ?></td>
            </tr>
            <tr>
                <th>Ngày đăng ký tài khoản</th>
                <td><?php echo e($customer->registration_date); ?></td>
            </tr>
        </table>

        <div class="d-flex gap-2">
            <a href="<?php echo e(route('password.change')); ?>" class="btn btn-info">Đổi mật khẩu</a>
            <a href="<?php echo e(route('customer.booking.history')); ?>" class="btn btn-info	">Xem lịch sử đặt phòng</a>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/auth/profile.blade.php ENDPATH**/ ?>
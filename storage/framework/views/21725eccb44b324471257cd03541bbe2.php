<?php $__env->startSection('content'); ?>
  <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h2 class="mb-4 text-center">Đăng Ký Tài Khoản</h2>
      
      <?php if(session('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo e(session('success')); ?>

      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

      
      <?php if($errors->any()): ?>
      <div class="alert alert-danger">
      <ul class="mb-0">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li><?php echo e($e); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      </div>
    <?php endif; ?>

      <div class="card shadow-sm">
      <div class="card-body">
        <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="row g-3">
          <div class="col-md-6">
          <label for="full_name" class="form-label">Họ tên</label>
          <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo e(old('full_name')); ?>"
            >    
          </div>

          <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" >
          </div>

          <div class="col-md-6">
          <label for="phone" class="form-label">Số điện thoại</label>
          <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" >
          </div>

          <div class="col-md-6">
          <label for="address" class="form-label">Địa chỉ</label>
          <input type="text" class="form-control" id="address" name="address" value="<?php echo e(old('address')); ?>"
            >
          </div>

          <div class="col-md-6">
          <label for="birth_day" class="form-label">Ngày sinh</label>
          <input type="date" class="form-control" id="birth_day" name="birth_day" value="<?php echo e(old('birth_day')); ?>"
            >
          </div>

          <div class="col-md-6">
          <label for="username" class="form-label">Tên đăng nhập</label>
          <input type="text" class="form-control" id="username" name="username" value="<?php echo e(old('username')); ?>"
            >
          </div>

          <div class="col-md-6">
          <label for="password" class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" id="password" name="password" >
          </div>

          <div class="col-md-6">
          <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            >
          </div>
        </div>

        <div class="mt-4 text-center">
          <button type="submit" class="btn btn-primary px-5">
          Đăng ký
          </button>
        </div>
        
        <div class="text-center mt-3">
          Bạn đã có tài khoản?
          <a href="<?php echo e(route('login')); ?>" class="btn btn-link p-0">Đăng nhập</a>
        </div>
        </form>
      </div>
      </div>

    </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/auth/register.blade.php ENDPATH**/ ?>
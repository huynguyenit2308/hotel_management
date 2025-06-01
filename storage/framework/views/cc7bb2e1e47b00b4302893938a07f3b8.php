<?php $__env->startSection('content'); ?>
    <section class="py-5">
        <div class="container padding-side">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-light rounded-top-4 text-center py-4">
                            <h1 class="mb-0">
                                <i class="bi bi-person-lines-fill me-2"></i>Cập Nhật Khách Hàng
                            </h1>
                        </div>

                        <div class="card-body p-4 bg-white rounded-bottom-4">
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- <?php if(session('error')): ?>
                                <div class="alert alert-danger">
                                    <?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?> -->
                            <form action="<?php echo e(route('customers.update', ['id' => $customer->id])); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('POST'); ?>
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger">
                                        <?php echo e(session('error')); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if(session('success')): ?>
                                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                                <?php endif; ?>
                                <input type="hidden" name="updated_at"
                                    value="<?php echo e($customer->updated_at->format('Y-m-d H:i:s.u')); ?>">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label fw-semibold">Họ và tên</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" id="full_name"
                                        name="full_name" placeholder="Nhập họ và tên..."
                                        value="<?php echo e(old('full_name', $customer->full_name)); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control rounded-3 shadow-sm" id="email" name="email"
                                        placeholder="Nhập email..." value="<?php echo e(old('email', $customer->email)); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" id="phone" name="phone"
                                        placeholder="Nhập số điện thoại..." value="<?php echo e(old('phone', $customer->phone)); ?>"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Địa chỉ</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" id="address" name="address"
                                        placeholder="Nhập địa chỉ..." value="<?php echo e(old('address', $customer->address)); ?>"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="birth_day" class="form-label fw-semibold">Ngày sinh</label>
                                    <input type="date" class="form-control rounded-3 shadow-sm" id="birth_day"
                                        name="birth_day" value="<?php echo e(old('birth_day', $customer->birth_day)); ?>" required>
                                </div>
                                <div class="d-flex gap-3">
                                    <a href="<?php echo e(route('customers.detail', ['id' => $customer->id])); ?>"
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/crud_customer/edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
    <?php
        use App\Helpers\IdEncoder;
        $encodedId = IdEncoder::encodeId($service->id);
    ?>
    <main class="py-5">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center display-4 mb-4">Đặt Dịch Vụ</h2>

            <div class="row align-items-stretch">
                <div class="col-md-6 d-flex">
                    <div class="card shadow rounded-4 p-4 w-100">
                        <form action="<?php echo e(route('post.booking.service')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="service_id" value="<?php echo e($encodedId); ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Dịch vụ</label>
                                <input type="text" class="form-control" value="<?php echo e($service->service_name); ?>" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label fw-bold">Ngày sử dụng</label>
                                <input type="date" name="date" id="date"
                                    class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('date')); ?>">
                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="time" class="form-label fw-bold">Giờ sử dụng</label>
                                <input type="time" name="time" id="time"
                                    class="form-control <?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('time')); ?>">
                                <?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Ghi chú (tuỳ chọn)</label>
                                <textarea name="note" id="note" rows="3" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('note')); ?></textarea>
                                <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="d-flex gap-3">
                                <a href="<?php echo e(route('home')); ?>"
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
                    <img src="<?php echo e(asset('storage/' . $service->image)); ?>" alt="<?php echo e($service->service_name); ?>"
                        onerror="this.onerror=null;this.src='<?php echo e(asset('images/default.jpg')); ?>';"
                        class="img-fluid rounded-4 object-fit-cover w-100 h-100">
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/userService/bookingService.blade.php ENDPATH**/ ?>
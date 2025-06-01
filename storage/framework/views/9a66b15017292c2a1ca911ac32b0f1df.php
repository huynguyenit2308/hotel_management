<?php $__env->startSection('content'); ?>
    <?php
        use App\Helpers\IdEncoder;
        $encodedId = IdEncoder::encodeId($service->id);
    ?>
    <section class="py-5">
        <div class="container padding-side">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-light rounded-top-4 text-center py-4">
                            <h1 class="mb-0">
                                <i class="bi bi-pencil-square me-2"></i>Cập Nhật Dịch Vụ
                            </h1>
                        </div>
                        <div class="card-body p-4 bg-white rounded-bottom-4">
                            <form action="<?php echo e(route('service.update', ['id' => $encodedId])); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="service_name" class="form-label fw-semibold">Tên dịch vụ</label>
                                    <input type="text"
                                        class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['service_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="service_name" name="service_name" placeholder="Nhập tên dịch vụ..."
                                        value="<?php echo e(old('service_name', $service->service_name)); ?>">
                                    <?php $__errorArgs = ['service_name'];
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
                                    <label for="price" class="form-label fw-semibold">Giá (VNĐ)</label>
                                    <input type="text"
                                        class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="price" name="price" placeholder="Nhập giá tiền..."
                                        value="<?php echo e(old('price', $service->price)); ?>">
                                    <?php $__errorArgs = ['price'];
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

                                <label for="image" class="form-label fw-semibold">Chọn ảnh mới (nếu muốn
                                    thay)</label>
                                <div class="mb-4">
                                    <input type="file"
                                        class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="image" name="image" accept="image/*" onchange="updateImage(event)">
                                    <?php $__errorArgs = ['image'];
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
                                <div class="mb-3 text-center">
                                    <?php if($service->image): ?>
                                        <img id="update" src="<?php echo e(asset('storage/' . $service->image)); ?>"
                                            onerror="this.onerror=null;this.src='<?php echo e(asset('images/default.jpg')); ?>';"
                                            alt="<?php echo e($service->service_name); ?>"
                                            class="img-fluid rounded-3 shadow-sm mb-2 d-inline-block"
                                            style="max-height: 250px;">
                                    <?php else: ?>
                                        <img id="update" src="<?php echo e(asset('images/default.jpg')); ?>" alt="Ảnh mặc địch"
                                            class="img-fluid rounded-3 shadow-sm mb-2 d-inline-block"
                                            style="max-height: 250px;">
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label fw-semibold">Mô tả</label>
                                    <textarea class="form-control rounded-3 shadow-sm <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description"
                                        name="description" rows="4" placeholder="Nhập mô tả dịch vụ..."><?php echo e(old('description', $service->description)); ?></textarea>
                                    <?php $__errorArgs = ['description'];
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
                                    <a href="<?php echo e(route('service.detail', ['id' => $encodedId])); ?>"
                                        class="btn btn-primary rounded-pill flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                                        style="transition: all 0.3s ease-in-out;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        <i class="bi bi-arrow-left-circle"></i> Trở lại chi tiết
                                    </a>
                                    <input type="hidden" name="updated_at" value="<?php echo e($service->updated_at); ?>">
                                    <button type="submit" id="saveButton"
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
    <?php if(session('error') === 'Dữ liệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang và thử lại.'): ?>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const saveButton = document.querySelector('#saveButton');
                if (saveButton) {
                    saveButton.disabled = true;
                    saveButton.classList.add('opacity-50', 'cursor-not-allowed');
                    saveButton.title = "Dữ liệu đã bị thay đổi, vui lòng tải lại trang.";
                }
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/crud_service/update.blade.php ENDPATH**/ ?>
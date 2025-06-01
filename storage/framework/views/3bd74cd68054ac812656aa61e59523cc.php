<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <h2 class="text-center display-4 fw-normal mb-5">Danh sách hóa đơn thanh toán</h2>
        <?php if(session('error')): ?>
            <div id="alert-error" class="alert alert-danger text-center d-flex justify-content-between align-items-center">
                <span><?php echo e(session('error')); ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="mb-4">
            <ul class="list-group">
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <div class="d-flex align-items-start gap-5">
                            <div style="flex-shrink: 0;">
                                <?php if($invoice->service->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $invoice->service->image)); ?>"
                                        alt="<?php echo e($invoice->service->service_name); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e(asset('images/default.jpg')); ?>';"
                                        class="img-fluid rounded-3 shadow-sm"
                                        style="width: 220px; height: 220px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/default.jpg')); ?>" alt="<?php echo e($invoice->service->service_name); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e(asset('images/default.jpg')); ?>';"
                                        class="img-fluid rounded-3 shadow-sm"
                                        style="width: 220px; height: 220px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div>

                                <h2 class="fw-bold"><?php echo e($invoice->service->service_name); ?></h2>
                                <p>Ngày đặt:
                                    <strong> <?php echo e(\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i')); ?></strong>
                                </p>
                                <p>Ngày sử dụng:
                                    <strong><?php echo e(\Carbon\Carbon::parse($invoice->booking_date)->format('d/m/Y H:i')); ?></strong>
                                </p>
                                <p>Giá dịch vụ:<strong> <?php echo e(number_format($invoice->service->price, 0, ',', '.')); ?>

                                        VND</strong></p>
                                <p>Ghi chú: <?php echo e($invoice->note ?? 'Không có ghi chú'); ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <form method="GET" action="<?php echo e(route('invoice.payment')); ?>">
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="invoice_ids[]" value="<?php echo e($invoice->id); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <select name="voucher_code" class="form-select" onchange="this.form.submit()">
                <option value="">-- Chọn voucher --</option>
                <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($voucher->code); ?>" <?php echo e($voucher->code == $voucherCode ? 'selected' : ''); ?>>
                        <?php echo e($voucher->code); ?> -
                        <?php echo e($voucher->type === 'percent' ? $voucher->value . '%' : number_format($voucher->value, 0, ',', '.') . ' VND'); ?>

                        - <span class="badge bg-info">Còn <?php echo e($voucher->usage_limit - $voucher->used_count); ?> lần sử
                            dụng</span>
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
        <div class="my-3 text-end">
            <p><strong>Tổng tiền:</strong> <?php echo e(number_format($originalTotal, 0, ',', '.')); ?> VND</p>
            <?php if($discount > 0): ?>
                <p class="text-success"><strong>Giảm giá:</strong> -<?php echo e(number_format($discount, 0, ',', '.')); ?> VND</p>
            <?php endif; ?>
            <p><strong>Thành tiền:</strong> <?php echo e(number_format($totalAmount, 0, ',', '.')); ?> VND</p>
        </div>

        <form action="<?php echo e(route('payment.cash.online')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="voucher_code" value="<?php echo e($voucherCode); ?>">
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="invoice_ids[]" value="<?php echo e($invoice->id); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <h4>Chọn phương thức thanh toán:</h4>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="cash" id="cash" checked>
                <label class="form-check-label" for="cash">
                    Thanh toán tiền mặt
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="online" id="online">
                <label class="form-check-label" for="online">
                    Thanh toán online (VNPay, Momo...)
                </label>
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?php echo e(route('invoice.list.user')); ?>"
                    class="py-3 btn btn-primary rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                    style="transition: all 0.3s ease-in-out; flex-basis: 30%; padding: 5px 15px; font-size: 14px;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="bi bi-arrow-left-circle"></i> Trở lại
                </a>
                <button type="submit"
                    class="py-3 btn btn-primary rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm"
                    style="transition: all 0.3s ease-in-out; border: none; flex-basis: 30%; padding: 5px 15px; font-size: 14px;"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(0, 123, 255, 0.3)'"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(0, 123, 255, 0.2)'">
                    <i class="bi bi-check-circle"></i> Xác nhận thanh toán
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/userService/payment.blade.php ENDPATH**/ ?>
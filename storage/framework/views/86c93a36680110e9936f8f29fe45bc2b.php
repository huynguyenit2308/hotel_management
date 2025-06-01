<?php $__env->startSection('content'); ?>
    <main>
        <section id="room" class="padding-medium">
            <div class="container-fluid padding-side" data-aos="fade-up">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h3 class="display-3 fw-normal text-center">Đặt phòng trực tuyến</h3>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="<?php echo e(route('bookings.index')); ?>" class="btn btn-outline-secondary">
                            <svg width="18" height="18" class="me-2">
                                <use xlink:href="#arrow-left"></use>
                            </svg>
                            Quay lại
                        </a>
                    </div>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success mt-3"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="alert alert-danger mt-3"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <div class="row mt-5">
                    <div class="col-md-6">
                        <form action="<?php echo e(route('bookings.storeOnline')); ?>" method="POST" class="p-4 bg-light rounded-4">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Họ và tên</label>
                                <input type="text" name="full_name" id="full_name" class="form-control <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('full_name')); ?>" required>
                                <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('phone')); ?>" required>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="room_id" class="form-label">Phòng</label>
                                <select name="room_id" id="room_id" class="form-select <?php $__errorArgs = ['room_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Chọn phòng</option>
                                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($room->id); ?>" <?php echo e(old('room_id', $room_id) == $room->id ? 'selected' : ''); ?>>
                                            <?php echo e($room->room_number); ?> - <?php echo e($room->room_type); ?> (<?php echo e(number_format($room->price, 0, ',', '.')); ?> VNĐ/đêm)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['room_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="check_in_date" class="form-label">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" id="check_in_date" class="form-control <?php $__errorArgs = ['check_in_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('check_in_date')); ?>" required>
                                <?php $__errorArgs = ['check_in_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="check_out_date" class="form-label">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" id="check_out_date" class="form-control <?php $__errorArgs = ['check_out_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('check_out_date')); ?>" required>
                                <?php $__errorArgs = ['check_out_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đặt phòng</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <?php if(isset($room_id)): ?>
                            <?php
                                $selectedRoom = $rooms->firstWhere('id', $room_id);
                            ?>
                            <?php if($selectedRoom): ?>
                                <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                                    <img src="<?php echo e(asset('images/room1.jpg')); ?>" alt="img" class="post-image img-fluid rounded-4">
                                    <div class="product-description position-absolute p-5 text-start">
                                        <h4 class="display-6 fw-normal text-white"><?php echo e($selectedRoom->room_type); ?></h4>
                                        <table>
                                            <tbody>
                                                <tr class="text-white">
                                                    <td class="pe-2">Số phòng:</td>
                                                    <td><?php echo e($selectedRoom->room_number); ?></td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Loại phòng:</td>
                                                    <td><?php echo e($selectedRoom->room_type); ?></td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Giá:</td>
                                                    <td class="price"><?php echo e(number_format($selectedRoom->price, 0, ',', '.')); ?> VNĐ /Đêm</td>
                                                </tr>
                                                <tr class="text-white">
                                                    <td class="pe-2">Dịch vụ:</td>
                                                    <td>Wifi, Tivi, Máy lạnh, ...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="room-item position-relative bg-black rounded-4 overflow-hidden">
                                <img src="<?php echo e(asset('images/room1.jpg')); ?>" alt="img" class="post-image img-fluid rounded-4">
                                <div class="product-description position-absolute p-5 text-start">
                                    <h4 class="display-6 fw-normal text-white">Thông tin phòng</h4>
                                    <table>
                                        <tbody>
                                            <tr class="text-white">
                                                <td class="pe-2">Số phòng:</td>
                                                <td id="room-number">-</td>
                                            </tr>
                                            <tr class="text-white">
                                                <td class="pe-2">Loại phòng:</td>
                                                <td id="room-type">-</td>
                                            </tr>
                                            <tr class="text-white">
                                                <td class="pe-2">Giá:</td>
                                                <td id="room-price" class="price">-</td>
                                            </tr>
                                            <tr class="text-white">
                                                <td class="pe-2">Dịch vụ:</td>
                                                <td>Wifi, Tivi, Máy lạnh, ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById('room_id').addEventListener('change', function() {
            const roomId = this.value;
            if (roomId) {
                const room = <?php echo json_encode($rooms->keyBy('id')->toArray(), 15, 512) ?>[roomId];
                document.getElementById('room-number').textContent = room.room_number;
                document.getElementById('room-type').textContent = room.room_type;
                document.getElementById('room-price').textContent = new Intl.NumberFormat('vi-VN').format(room.price) + ' VNĐ /Đêm';
            } else {
                document.getElementById('room-number').textContent = '-';
                document.getElementById('room-type').textContent = '-';
                document.getElementById('room-price').textContent = '-';
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/bookings/create.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Chi tiết Nhân viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('employees.index')); ?>">Nhân viên</a></li>
        <li class="breadcrumb-item active">Chi tiết nhân viên</li>
    </ol>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-user me-1"></i>
                Thông tin chi tiết nhân viên
            </div>
            <div>
                <a href="<?php echo e(route('employees.edit', $employee->id)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </a>
                <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="mb-4">Thông tin cá nhân</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">Mã nhân viên</th>
                                <td><?php echo e($employee->id); ?></td>
                            </tr>
                            <tr>
                                <th>Họ và tên</th>
                                <td><?php echo e($employee->full_name); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo e($employee->email); ?></td>
                            </tr>
                            <tr>
                                <th>Số điện thoại</th>
                                <td><?php echo e($employee->phone); ?></td>
                            </tr>
                            <tr>
                                <th>Địa chỉ</th>
                                <td><?php echo e($employee->address ?? 'Chưa cập nhật'); ?></td>
                            </tr>
                            <tr>
                                <th>Ngày sinh</th>
                                <td><?php echo e($employee->birth_day ? \Carbon\Carbon::parse($employee->birth_day)->format('d/m/Y') : 'Chưa cập nhật'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="m-0">Trạng thái</h5>
                        </div>
                        <div class="card-body text-center">
                            <?php if($employee->status == 1): ?>
                            <span class="badge bg-success fs-6 p-2 mb-3">Đang làm việc</span>
                            <?php else: ?>
                            <span class="badge bg-danger fs-6 p-2 mb-3">Đã nghỉ việc</span>
                            <?php endif; ?>
                            
                            <div class="mb-2 mt-4 text-start">
                                <strong>Vị trí:</strong> <?php echo e($employee->position); ?>

                            </div>
                            <div class="mb-2 text-start">
                                <strong>Ngày tuyển dụng:</strong> <?php echo e(\Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y')); ?>

                            </div>
                            <div class="mb-2 text-start">
                                <strong>Quyền:</strong> <?php echo e($employee->adminRole->role_name); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="m-0">Thông tin công việc</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Lương hiện tại:</strong>
                                        <div class="fs-4 text-primary"><?php echo e(number_format($employee->salary, 0, ',', '.')); ?> VNĐ</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Thời gian làm việc:</strong>
                                        <div>
                                            <?php
                                                $hireDate = \Carbon\Carbon::parse($employee->hire_date);
                                                $now = \Carbon\Carbon::now();
                                                $years = $now->diffInYears($hireDate);
                                                $months = $now->copy()->subYears($years)->diffInMonths($hireDate);
                                            ?>
                                            <?php echo e($years); ?> năm <?php echo e($months); ?> tháng
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Mô tả quyền và chức năng</h6>
                                    <p><?php echo e($employee->adminRole->description ?? 'Không có mô tả'); ?></p>
                                    
                                    <?php if($employee->adminRole->permissions): ?>
                                    <h6>Các quyền:</h6>
                                    <div class="d-flex flex-wrap">
                                        <?php $__currentLoopData = $employee->adminRole->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-info m-1"><?php echo e($permission); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="m-0">Thao tác</h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <a href="<?php echo e(route('employees.edit', $employee->id)); ?>" class="btn btn-primary mb-2">
                                <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                            </a>
                            <form action="<?php echo e(route('employees.destroy', $employee->id)); ?>" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');" class="mt-auto">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash"></i> Xóa nhân viên
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/employees/show.blade.php ENDPATH**/ ?>
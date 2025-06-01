<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản lý Nhân viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Nhân viên</li>
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
                <i class="fas fa-table me-1"></i>
                Danh sách Nhân viên
            </div>
            <div>
                <?php if(Auth::check() && Auth::user()->adminRole && (Auth::user()->adminRole->role_name == 'Super Admin' || Auth::user()->adminRole->role_name == 'Admin')): ?>
                <a href="<?php echo e(route('salaries.index')); ?>" class="btn btn-info me-2">
                    <i class="fas fa-money-bill-wave me-1"></i> Quản lý Lương
                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-primary">Thêm Nhân viên</a>
            </div>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('employees.index')); ?>" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên, email, điện thoại" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select name="position" class="form-select">
                            <option value="">-- Tất cả vị trí --</option>
                            <option value="Lễ tân" <?php echo e(request('position') == 'Lễ tân' ? 'selected' : ''); ?>>Lễ tân</option>
                            <option value="Phục vụ" <?php echo e(request('position') == 'Phục vụ' ? 'selected' : ''); ?>>Phục vụ</option>
                            <option value="Quản lý" <?php echo e(request('position') == 'Quản lý' ? 'selected' : ''); ?>>Quản lý</option>
                            <option value="Bảo vệ" <?php echo e(request('position') == 'Bảo vệ' ? 'selected' : ''); ?>>Bảo vệ</option>
                            <option value="Nhân viên vệ sinh" <?php echo e(request('position') == 'Nhân viên vệ sinh' ? 'selected' : ''); ?>>Nhân viên vệ sinh</option>
                            <option value="Đầu bếp" <?php echo e(request('position') == 'Đầu bếp' ? 'selected' : ''); ?>>Đầu bếp</option>
                            <option value="Kế toán" <?php echo e(request('position') == 'Kế toán' ? 'selected' : ''); ?>>Kế toán</option>
                            <option value="Nhân viên kỹ thuật" <?php echo e(request('position') == 'Nhân viên kỹ thuật' ? 'selected' : ''); ?>>Nhân viên kỹ thuật</option>
                            <option value="Nhân viên nhà hàng" <?php echo e(request('position') == 'Nhân viên nhà hàng' ? 'selected' : ''); ?>>Nhân viên nhà hàng</option>
                            <option value="Quản lý nhân sự" <?php echo e(request('position') == 'Quản lý nhân sự' ? 'selected' : ''); ?>>Quản lý nhân sự</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select name="status" class="form-select">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Đang làm việc</option>
                            <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Đã nghỉ việc</option>
                            <option value="2" <?php echo e(request('status') == '2' ? 'selected' : ''); ?>>Nghỉ phép</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                        <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-secondary">Đặt lại</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Vị trí</th>
                            <th>Lương</th>
                            <th>Ngày tuyển dụng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($employee->id); ?></td>
                            <td><?php echo e($employee->full_name); ?></td>
                            <td><?php echo e($employee->email); ?></td>
                            <td><?php echo e($employee->phone); ?></td>
                            <td><?php echo e($employee->position); ?></td>
                            <td><?php echo e(number_format($employee->salary, 0, ',', '.')); ?> VNĐ</td>
                            <td><?php echo e(\Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y')); ?></td>
                            <td>
                                <?php if($employee->status == 1): ?>
                                <span class="badge bg-success">Đang làm việc</span>
                                <?php elseif($employee->status == 0): ?>
                                <span class="badge bg-danger">Đã nghỉ việc</span>
                                <?php elseif($employee->status == 2): ?>
                                <span class="badge bg-warning">Nghỉ phép</span>
                                <?php else: ?>
                                <span class="badge bg-secondary">Không xác định</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="<?php echo e(route('employees.show', $employee->id)); ?>" class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('employees.edit', $employee->id)); ?>" class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('employees.destroy', $employee->id)); ?>" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center">Không có nhân viên nào</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted mb-0">Hiển thị <?php echo e($employees->firstItem() ?? 0); ?> đến <?php echo e($employees->lastItem() ?? 0); ?> của <?php echo e($employees->total()); ?> nhân viên</p>
                </div>
                <div>
                    <?php echo e($employees->onEachSide(1)->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-item .page-link {
        border-radius: 0.2rem;
        margin: 0 3px;
        color: #5a5c69;
        font-size: 0.9rem;
    }
    .pagination .page-item.active .page-link {
        background-color: #4e73df;
        border-color: #4e73df;
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        color: #b7b9cc;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0.8rem;
    }
    .table th {
        font-weight: 600;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/employees/index.blade.php ENDPATH**/ ?>
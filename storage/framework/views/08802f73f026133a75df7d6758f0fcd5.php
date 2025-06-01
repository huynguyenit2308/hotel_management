<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="display-4">Danh sách quản lý phòng</h2>
        <a href="<?php echo e(route('rooms.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Thêm phòng mới
        </a>
    </div>

    <div id="alert-container" class="position-fixed top-0 start-50 translate-middle-x" style="z-index: 1050; width: 100%; max-width: 500px;"></div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('rooms.index')); ?>" class="row g-5">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo số phòng..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-bed text-primary"></i>
                        </span>
                        <select name="room_type" class="form-select">
                            <option value="">Tất cả loại phòng</option>
                            <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type); ?>" <?php echo e(request('room_type') == $type ? 'selected' : ''); ?>>
                                    <?php echo e($type); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-info-circle text-primary"></i>
                        </span>
                        <select name="status" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status->id); ?>" <?php echo e(request('status') == $status->id ? 'selected' : ''); ?>>
                                    <?php echo e($status->status_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="padding: 10px 20px 5px 20px;">
                        <i class="fas fa-filter"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if($rooms->isEmpty()): ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i>
            Không tìm thấy phòng nào phù hợp với tiêu chí tìm kiếm.
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-door-open text-primary me-2"></i>
                                    Phòng <?php echo e($room->room_number); ?>

                                </h5>
                                <span class="badge bg-<?php echo e($room->status->status_name == 'Available' ? 'success' : ($room->status->status_name == 'Occupied' ? 'danger' : 'warning')); ?>">
                                    <?php echo e($room->status->status_name); ?>

                                </span>
                            </div>
                            <div class="mb-3">
                                <p class="mb-2">
                                    <i class="fas fa-bed text-primary me-2"></i>
                                    <strong>Loại phòng:</strong> <?php echo e($room->room_type); ?>

                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-money-bill-wave text-primary me-2"></i>
                                    <strong>Giá:</strong> <?php echo e(number_format($room->price)); ?> VNĐ
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('rooms.show', $room)); ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <div>
                                    <a href="<?php echo e(route('rooms.edit', $room)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('rooms.destroy', $room)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-lg">
                    
                    <?php if($rooms->onFirstPage()): ?>
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($rooms->previousPageUrl()); ?>" aria-label="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $rooms->getUrlRange(1, $rooms->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $rooms->currentPage()): ?>
                            <li class="page-item active">
                                <span class="page-link"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($rooms->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($rooms->nextPageUrl()); ?>" aria-label="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show w-100`;
    alert.style.height = '30px';
    alert.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertContainer.appendChild(alert);
    setTimeout(() => {
        alert.remove();
    }, 3000);
}

<?php if(session('success')): ?>
    showAlert('<?php echo e(session('success')); ?>');
<?php endif; ?>

<?php if(session('error')): ?>
    showAlert('<?php echo e(session('error')); ?>', 'danger');
<?php endif; ?>

<?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        showAlert('<?php echo e($error); ?>', 'danger');
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.25rem;
    transition: all 0.3s ease;
}

.page-link:hover {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.page-item.active .page-link {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.65;
}

.page-link i {
    font-size: 0.875rem;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/rooms/index.blade.php ENDPATH**/ ?>
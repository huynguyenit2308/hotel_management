<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Danh sách khách hàng</h1>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        
        <form action="<?php echo e(route('customers.list')); ?>" method="GET" class="d-flex mb-3 justify-content-center" role="search">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên..."
                    value="<?php echo e(request('keyword')); ?>">
                <button class="btn btn-outline-secondary" type="submit">Tìm Kiếm</button>
            </div>
        </form>

        
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Ngày đăng ký</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($customers->currentPage() - 1) * $customers->perPage() + $index + 1); ?></td>
                        <td><?php echo e($customer->full_name); ?></td>
                        <td><?php echo e($customer->phone); ?></td>
                        <td><?php echo e($customer->registration_date); ?></td>
                        <td>
                            <a href="<?php echo e(route('customers.detail', ['id' => $customer->id])); ?>" class="btn btn-info btn-sm">Chi
                                tiết</a>
                            <a href="<?php echo e(route('customers.delete', ['id' => $customer->id])); ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">
                                Xóa
                            </a>
                            <a href="<?php echo e(route('customers.edit', ['id' => $customer->id])); ?>"
                                class="btn btn-warning btn-sm">Sửa</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <?php if($customers->hasPages()): ?>
            <ul class="pagination-custom">
                
                <?php if($customers->onFirstPage()): ?>
                    <li class="disabled"><span>&lsaquo;</span></li>
                <?php else: ?>
                    <li><a href="<?php echo e($customers->previousPageUrl()); ?>" rel="prev">&lsaquo;</a></li>
                <?php endif; ?>

                
                <?php $__currentLoopData = $customers->links()->elements[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $customers->currentPage()): ?>
                        <li class="active"><span><?php echo e($page); ?></span></li>
                    <?php else: ?>
                        <li><a href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($customers->hasMorePages()): ?>
                    <li><a href="<?php echo e($customers->nextPageUrl()); ?>" rel="next">&rsaquo;</a></li>
                <?php else: ?>
                    <li class="disabled"><span>&rsaquo;</span></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<style>
    .pagination-custom {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin-top: 20px;
    }

    .pagination-custom li {
        margin: 0 4px;
    }

    .pagination-custom li a,
    .pagination-custom li span {
        display: inline-block;
        padding: 8px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        background-color: #fff;
    }

    .pagination-custom li a:hover {
        background-color: #eee;
    }

    .pagination-custom .active span {
        background-color: #d35400;
        color: #fff;
        font-weight: bold;
        border-color: #d35400;
    }

    .pagination-custom .disabled span {
        color: #999;
        background-color: #f0f0f0;
        pointer-events: none;
    }
</style>
<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\BE2\hotel_management\resources\views/crud_customer/list.blade.php ENDPATH**/ ?>
<?php if($paginator->hasPages()): ?>
    <nav class="d-flex justify-content-center my-4">
        <ul class="pagination d-flex gap-2">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link p-2 rounded-circle border-0" style="background-color: #d2691e; width: 14px; height: 14px; display: inline-block;"></span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link p-2 rounded-circle border-0" href="<?php echo e($url); ?>" style="background-color: #f6e1d3; width: 14px; height: 14px; display: inline-block;"></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH D:\BE2\hotel_management\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>
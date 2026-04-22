<?php if(request()->routeIs($url)): ?>
 <?php $__env->startPush('show'); ?>
    'show'
 <?php $__env->stopPush(); ?>
 <?php endif; ?>
<li class="<?php echo e(request()->routeIs($url) ? 'active' : ''); ?>">
    <a href="<?php echo e(route($url)); ?>">
    <span class="sub-item"><?php echo e($text); ?></span>
    </a>
</li>


<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/admin/sidebar/ui/dropdown-list.blade.php ENDPATH**/ ?>
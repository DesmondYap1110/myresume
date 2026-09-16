
<div class="page-header">
    <h3 class="fw-bold mb-3"><?php echo e($breadcrumbs['CurrentPage']); ?></h3>
    <?php if(isset($breadcrumbs['isDashboard'])): ?>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="<?php echo e($breadcrumbs['homeUrl']); ?>"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="<?php echo e($breadcrumbs['CurrentUrl']); ?>"><?php echo e($breadcrumbs['CurrentPage']); ?></a></li>
        <?php if(isset($breadcrumbs['list'])): ?>
        <?php $__currentLoopData = $breadcrumbs['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="<?php echo e($list['url']); ?>"><?php echo e($list['text']); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/admin/header/breadcrumbs-main.blade.php ENDPATH**/ ?>
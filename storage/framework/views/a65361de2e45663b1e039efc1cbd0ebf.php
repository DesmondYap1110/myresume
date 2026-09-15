<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?php echo e(asset('assets/admin/img/kaiadmin/favicon.ico')); ?>" type="image/x-icon">
    <title><?php echo $__env->yieldPushContent('title'); ?></title>

    <!-- Global stylesheets -->
    <?php echo $__env->make('components.template1.website.master.master-style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body id="page-top">

    
    <div class="boot-screen" aria-hidden="true">
        <div class="boot-inner">
            <div class="boot-line"><span class="boot-prompt">&gt;</span> initializing portfolio<span class="boot-dots"></span></div>
            <div class="boot-bar"><span></span></div>
            <div class="boot-meta"><span class="boot-percent">0</span>%</div>
        </div>
    </div>
    <div class="scroll-progress" aria-hidden="true"><span></span></div>

    <?php echo e($slot); ?>


    <!-- Global javascript -->
    <?php echo $__env->make('components.template1.website.master.master-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/master/master-layout.blade.php ENDPATH**/ ?>
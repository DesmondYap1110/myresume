<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SAP PM Adrian</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="icon" href="<?php echo e(asset("assets/admin/img/kaiadmin/favicon.ico")); ?>" type="image/x-icon" />

    <?php if (isset($component)) { $__componentOriginal270d1b8333d7d2cf2e460b5d57453f84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal270d1b8333d7d2cf2e460b5d57453f84 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.master.master-style','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.master.master-style'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal270d1b8333d7d2cf2e460b5d57453f84)): ?>
<?php $attributes = $__attributesOriginal270d1b8333d7d2cf2e460b5d57453f84; ?>
<?php unset($__attributesOriginal270d1b8333d7d2cf2e460b5d57453f84); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal270d1b8333d7d2cf2e460b5d57453f84)): ?>
<?php $component = $__componentOriginal270d1b8333d7d2cf2e460b5d57453f84; ?>
<?php unset($__componentOriginal270d1b8333d7d2cf2e460b5d57453f84); ?>
<?php endif; ?>

    </head>
    <body class="<?php echo e(request()->routeIs('login.index', 'login.logout') ? 'login bg-primary' : ''); ?>">
        <div class="wrapper <?php echo e(request()->routeIs('login.index', 'login.logout') ? 'wrapper-login' : ''); ?>">
            <?php if(!request()->routeIs('login.index', 'login.logout')): ?>
            <!-- Sidebar -->
            <?php echo $__env->make('components.template1.admin.sidebar.sidebar-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- End Sidebar -->

            <div class="main-panel">
                <!-- Header -->
                <?php echo $__env->make('components.template1.admin.header.header-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- End Header -->
                <div class="container">
                    <div class="page-inner">
                        <?php echo e($slot); ?>

                    </div>
                </div>
                <!-- Footer -->
                <?php echo $__env->make('components.template1.admin.footer.footer-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- End Footer -->
            </div>
            <?php else: ?>
                <?php echo e($slot); ?>

            <?php endif; ?>
        <div>
        <?php echo $__env->make('components.template1.admin.master.master-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </body>

</html>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/admin/master/master-layout.blade.php ENDPATH**/ ?>
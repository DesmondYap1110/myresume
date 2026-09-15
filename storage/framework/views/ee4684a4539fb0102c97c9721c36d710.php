<!-- CSS Files -->
<link rel="stylesheet" href="<?php echo e(asset("assets/admin/css/bootstrap.min.css")); ?>"/>
<link rel="stylesheet" href="<?php echo e(asset("assets/admin/css/bootstrap-datepicker.min.css")); ?>"/>
<link rel="stylesheet" href="<?php echo e(asset("assets/admin/css/plugins.min.css")); ?>" />
<link rel="stylesheet" href="<?php echo e(asset("assets/admin/css/kaiadmin.min.css")); ?>"/>
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/filepond.min.css')); ?>" />

<?php if (isset($component)) { $__componentOriginal1ae4ce95b458c4cfc7082ef256e2590e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1ae4ce95b458c4cfc7082ef256e2590e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.master.branding-styles','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.master.branding-styles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1ae4ce95b458c4cfc7082ef256e2590e)): ?>
<?php $attributes = $__attributesOriginal1ae4ce95b458c4cfc7082ef256e2590e; ?>
<?php unset($__attributesOriginal1ae4ce95b458c4cfc7082ef256e2590e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1ae4ce95b458c4cfc7082ef256e2590e)): ?>
<?php $component = $__componentOriginal1ae4ce95b458c4cfc7082ef256e2590e; ?>
<?php unset($__componentOriginal1ae4ce95b458c4cfc7082ef256e2590e); ?>
<?php endif; ?>


<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/admin/master/master-style.blade.php ENDPATH**/ ?>
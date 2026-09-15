<link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:100,200,300,400,500,600,700,800,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<link href="<?php echo e(asset('assets/website/css/bootstrap/bootstrap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('assets/website/css/devicons/css/devicons.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('assets/website/css/simple-line-icons/css/simple-line-icons.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('assets/website/css/style.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('assets/website/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
<?php if (isset($component)) { $__componentOriginal67c793af53108cb7d9799860fb9792a7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal67c793af53108cb7d9799860fb9792a7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.master.branding-styles','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.master.branding-styles'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal67c793af53108cb7d9799860fb9792a7)): ?>
<?php $attributes = $__attributesOriginal67c793af53108cb7d9799860fb9792a7; ?>
<?php unset($__attributesOriginal67c793af53108cb7d9799860fb9792a7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal67c793af53108cb7d9799860fb9792a7)): ?>
<?php $component = $__componentOriginal67c793af53108cb7d9799860fb9792a7; ?>
<?php unset($__componentOriginal67c793af53108cb7d9799860fb9792a7); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/master/master-style.blade.php ENDPATH**/ ?>
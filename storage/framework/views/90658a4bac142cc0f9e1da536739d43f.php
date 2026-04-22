<?php $__env->startPush('title'); ?>
Dashboard
<?php $__env->stopPush(); ?>
<?php if (isset($component)) { $__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.master.master-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.master.master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <?php if (isset($component)) { $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.card.card','data' => ['icon' => 'fas fa-user','text' => 'Total Visitors','data' => $visit_log]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.card.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fas fa-user','text' => 'Total Visitors','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($visit_log)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $attributes = $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $component = $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.card.card','data' => ['icon' => 'fas fa-user','text' => 'Visitors Today','data' => $visit_log]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.card.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fas fa-user','text' => 'Visitors Today','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($visit_log)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $attributes = $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $component = $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.card.card','data' => ['icon' => 'fas fa-envelope','text' => 'Inbox Messages','data' => $inbox]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.card.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fas fa-envelope','text' => 'Inbox Messages','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inbox)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $attributes = $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $component = $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f)): ?>
<?php $attributes = $__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f; ?>
<?php unset($__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f)): ?>
<?php $component = $__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f; ?>
<?php unset($__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f); ?>
<?php endif; ?>

<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/dashboard/index.blade.php ENDPATH**/ ?>
<?php
    $isOpen = collect($menulist)->contains(fn($list) => Route::is($list['url']));
?>


<li class="nav-item">
    <a data-bs-toggle="collapse" href="#sidebarLayouts">
        <i class="<?php echo e($icon); ?>"></i>
        <p><?php echo e($title); ?></p>
        <span class="caret"></span>
    </a>
    <div class="collapse <?php echo e($isOpen ? 'show' : ''); ?>" id="sidebarLayouts">
        <ul class="nav nav-collapse">
        <?php $__currentLoopData = $menulist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if (isset($component)) { $__componentOriginalf3767b61bddd32fecc51f910d9a41581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3767b61bddd32fecc51f910d9a41581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.sidebar.ui.dropdown-list','data' => ['text' => ''.e($list['text']).'','url' => ''.e($list['url']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.sidebar.ui.dropdown-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => ''.e($list['text']).'','url' => ''.e($list['url']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3767b61bddd32fecc51f910d9a41581)): ?>
<?php $attributes = $__attributesOriginalf3767b61bddd32fecc51f910d9a41581; ?>
<?php unset($__attributesOriginalf3767b61bddd32fecc51f910d9a41581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3767b61bddd32fecc51f910d9a41581)): ?>
<?php $component = $__componentOriginalf3767b61bddd32fecc51f910d9a41581; ?>
<?php unset($__componentOriginalf3767b61bddd32fecc51f910d9a41581); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</li>
<?php /**PATH C:\laragon\www\my-portfolio\resources\views/components/template1/admin/sidebar/ui/dropdown.blade.php ENDPATH**/ ?>
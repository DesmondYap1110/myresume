<?php $__env->startPush('title'); ?>
<?php echo e($breadcrumbs['CurrentPage']); ?>

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
    <?php if (isset($component)) { $__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.header.breadcrumbs-main','data' => ['breadcrumbs' => $breadcrumbs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.header.breadcrumbs-main'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8)): ?>
<?php $attributes = $__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8; ?>
<?php unset($__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8)): ?>
<?php $component = $__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8; ?>
<?php unset($__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8); ?>
<?php endif; ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Testimonials</div>
                    <div class="card-tools">
                        <a href="<?php echo e(route('testimonial.add')); ?>" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="Add Testimonial">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-category">What clients say about you. Shown on your website.</div>
            </div>
            <div class="card-body">
                <?php if(count($testimonial)): ?>
                <div class="row">
                    <?php $__currentLoopData = $testimonial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-round">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <?php if($data->image): ?>
                                    <img src="<?php echo e($data->image); ?>" alt="<?php echo e($data->name); ?>" class="rounded-circle me-3" style="width:52px;height:52px;object-fit:cover">
                                    <?php else: ?>
                                    <span class="rounded-circle me-3 d-inline-flex align-items-center justify-content-center fw-bold"
                                          style="width:52px;height:52px;background:var(--brand-primary,#212529);color:var(--brand-button-text,#FFD700)"><?php echo e($data->initials()); ?></span>
                                    <?php endif; ?>
                                    <div>
                                        <b><?php echo e($data->name); ?></b>
                                        <div class="text-muted text-small"><?php echo e($data->position); ?></div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo e($i <= $data->rating ? '' : 'text-muted opacity-25'); ?>" style="<?php echo e($i <= $data->rating ? 'color:var(--brand-accent,#FFD700)' : ''); ?>"></i>
                                    <?php endfor; ?>
                                    <span class="text-muted text-small ms-2">Order <?php echo e($data->sort_order); ?></span>
                                </div>
                                <p class="text-muted fst-italic mb-0">"<?php echo e(Str::limit($data->message, 160)); ?>"</p>
                            </div>
                            <div class="card-header d-flex justify-content-end align-items-center">
                                <a href="<?php echo e(route('testimonial.edit', $data->id)); ?>" class="btn btn-success btn-sm m-1">Edit</a>
                                <a href="<?php echo e(route('testimonial.delete', $data->id)); ?>" class="btn btn-danger btn-sm m-1" onclick="return confirm('Delete this testimonial?')">Delete</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    Empty <?php echo e($breadcrumbs['CurrentPage']); ?>. Add <a href="<?php echo e(route('testimonial.add')); ?>"><?php echo e($breadcrumbs['CurrentPage']); ?></a>.
                </div>
                <?php endif; ?>
            </div>
        </div>
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
<?php /**PATH C:\laragon\www\myresume\resources\views/admin/template1/testimonial/index.blade.php ENDPATH**/ ?>
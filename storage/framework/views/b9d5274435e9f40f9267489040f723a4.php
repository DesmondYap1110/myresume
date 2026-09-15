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
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Password</div>
            </div>
            <div class="form-group form-show-validation row">
                <label for="email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">E-mail <span class="required-label">*</span></label>
                <div class="col-lg-4 col-md-9 col-sm-8">
                    <input type="email" class="form-control" id="email" placeholder="Enter Email" disabled value="<?php echo e(Auth::user()->email); ?>">
                </div>
            </div>
            <form action="<?php echo e(route("setting.update")); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-group form-show-validation row">
                    <label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Password <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                </div>
                <div class="form-group form-show-validation row">
                    <label for="confirmpassword" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Confirm Password <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="btn btn-success" type="submit" value="Submit">
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
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

<?php /**PATH C:\laragon\www\my-portfolio\resources\views/admin/template1/setting/index.blade.php ENDPATH**/ ?>
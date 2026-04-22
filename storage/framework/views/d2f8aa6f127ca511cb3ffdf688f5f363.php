<?php $__env->startPush('title'); ?>
Login
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
    <div class="container container-login animated fadeIn" style="display: block;">
        <h3 class="text-center">Sign In</h3>
        <div class="login-form">
            <form method="POST" action="<?php echo e(route('login.submit')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-sub">
                    <div class="form-floating form-floating-custom mb-3">
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="form-floating form-floating-custom mb-3">
                        <input id="password" name="password" type="password" class="form-control" placeholder="password" required>
                        <label for="password">Password</label>
                        <div class="show-password">
                        <i class="icon-eye"></i>
                        </div>
                    </div>
                </div>
                <div class="form-action mb-3">
                    <button type="submit" class="btn btn-primary w-100 btn-login">Sign In</button>
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
<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/login/index.blade.php ENDPATH**/ ?>
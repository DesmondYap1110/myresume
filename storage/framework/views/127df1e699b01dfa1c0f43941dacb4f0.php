<?php $__env->startPush('script'); ?>

<script>
$(document).ready(function () {
    $('#yearpick').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('title'); ?>
<?php echo e($breadcrumbs['list']['0']['text']); ?>

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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Add Education</div>
                </div>
            </div>
            <form action="<?php echo e(route("education.create")); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="institution">Institution <span>*</span></label>
                            <input type="text" class="form-control" id="institution" name="institution" placeholder="Enter Institution" value="<?php echo e(old('institution')); ?>" required>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="certificate">Certicate<span>*</span></label>
                            <input type="text" class="form-control" id="certificate" name="certificate" placeholder="Enter Certification" value="<?php echo e(old('certificate')); ?>"  required>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="archivement">Achievement <span>*</span></label>
                            <textarea class="form-control" rows="4" placeholder="Enter your achievement" name="achievement"><?php echo e(old('achievement')); ?></textarea>
                        </div>
                        <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                            <label>Year <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="yearpick" name="year" required value="<?php echo e(old('year')); ?>">
                                <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-dark">Submit</button>
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


<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/education/add.blade.php ENDPATH**/ ?>
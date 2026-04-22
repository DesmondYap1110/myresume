
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
                        <div class="card-title">Edit Experience</div>
                    </div>
                </div>
                <form action="<?php echo e(route('experience.update',request()->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" name="work_status" id="work_status" <?php if($experience->work_status): ?> checked <?php endif; ?>>
                                    <label class="mb-0" for="flexCheckChecked">
                                        Currently Working?
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label for="company">Company <span>*</span></label>
                                <input type="text" class="form-control" id="company" placeholder="Enter Company Name" required name="company" value="<?php echo e($experience->company); ?>">
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label for="position">Position Role <span>*</span></label>
                                <input type="text" class="form-control" id="position" placeholder="Enter Position Role" required name="role" value="<?php echo e($experience->role); ?>">
                            </div>

                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>Start Date <span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker2" name="start_date" required name="start_date" value="<?php echo e($experience->start_date); ?>">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1" id="togglehide">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker3" name="end_date" name="end_date" value="<?php echo e($experience->end_date); ?>">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-title summertext" data-placeholder = "Please Fill In Detail">Detail</div>
                        <textarea name="detail" id="summernote" class="form-control" required><?php echo $experience->detail; ?></textarea>
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

<script>
$('.datepicker').datetimepicker({
    format: 'YYYY-MM',
});

$('#work_status').on('change', function () {

    if (this.checked) {
        $('#togglehide').hide();

        // remove required
        $('#togglehide input').prop('required', false);

        // RESET VALUES (important)
        $('#togglehide input').val('');
    }
    else
    {
        $('#togglehide').show();
        $('#togglehide input').prop('required', true);
    }

}).trigger('change');


</script>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/experience/edit.blade.php ENDPATH**/ ?>
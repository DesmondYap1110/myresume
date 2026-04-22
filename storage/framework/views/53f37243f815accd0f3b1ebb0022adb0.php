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
                    <div class="card-title">Subject:<span class="text-black">&nbsp;<?php echo e($inbox->subject); ?>&nbsp;</span></div>
                </div>
            </div>
            <div class="card-action">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                        <div class="form-check d-flex align-items-center">
                            <input
                                class="form-check-input mark-read"
                                type="checkbox"
                                onclick="updateStatus()"
                                <?php if($inbox->read_status): ?> checked <?php endif; ?>
                            >

                            <label class="mb-0">Mark as read</label>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                        <label for="name">Name </label>
                        <input type="text" class="form-control" id="company" disabled name="name" value="<?php echo e($inbox->name); ?>">
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                        <label for="email"> Email</label>
                        <input type="text" class="form-control" id="position" disabled name="email" value="<?php echo e($inbox->email); ?>">
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                        <label for="description"> Description </label>
                        <textarea name="detail"  class="form-control" disabled><?php echo $inbox->description; ?></textarea>
                    </div>
                </div>
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

<script>
function updateStatus()
{

    $.ajax({
        url: "<?php echo e(route('inbox.status2',request()->route('id'))); ?>",
        type: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function(response)
        {
            console.log(response.message);
        }
    });
}

</script>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/inbox/viewmessage.blade.php ENDPATH**/ ?>
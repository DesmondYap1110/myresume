<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="blog">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Blog</h2>
        <div class="mb-5 heading-border"></div>
        </div>

    </div>
    <div class="row my-auto">
        <?php $__currentLoopData = $blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-4 blog-item filter finance">
            <a class="blog-link" href="javascript:void(0);" data-id="<?php echo e($data->id); ?>" data-toggle="modal" onclick='openModal(<?php echo json_encode($data, 15, 512) ?>)'>
                <div class="caption-port">
                    <div class="caption-port-content">
                        <i class="fa fa-search-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="<?php echo e($data->image); ?>" alt="<?php echo e($data->image); ?>">
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</section>

<!--====================================================
                    BLOG MODALS
======================================================-->
<?php if (isset($component)) { $__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.modal.modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.modal.modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1)): ?>
<?php $attributes = $__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1; ?>
<?php unset($__attributesOriginalf1a18a487b70dfb757bb0fe437f9fce1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1)): ?>
<?php $component = $__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1; ?>
<?php unset($__componentOriginalf1a18a487b70dfb757bb0fe437f9fce1); ?>
<?php endif; ?>

<script>
function openModal(data)
{
    $('#blog-title').text(data.title);
    $('#blog-image').attr('src', data.image);
    $('#blog-content').html(data.description);

    $('#portfolioModal').modal('show'); //
}

</script>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/body/blog.blade.php ENDPATH**/ ?>
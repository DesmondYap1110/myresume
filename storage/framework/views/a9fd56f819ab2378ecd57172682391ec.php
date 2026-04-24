<?php $__env->startPush('script'); ?>
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: false,
    acceptedFileTypes: ['image/*'],
    instantUpload: false ,  // preview only, no auto upload
    storeAsFile: true
});


$("#imageInput").on("change", function (e) {

    let file = e.target.files[0];
    if (file)
    {
        $("#existing_pond_file").val('');
        let reader = new FileReader();
        reader.onload = function (event) {
            $("#preview")
                .attr("src", event.target.result)
                .show();
        };
        reader.readAsDataURL(file);
    }
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
                        <div class="card-title">Edit Blog</div>
                    </div>
                </div>
                <form action="<?php echo e(route("blog.update",request()->id)); ?>" method = "post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="title">Title <span>*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required value="<?php echo e($blog->title); ?>">
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="archivement">Description <span>*</span></label>
                                <textarea class="form-control" rows="4" placeholder="Enter Description of Blog" name="description"><?php echo e($blog->description); ?></textarea>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="image">Image<span>*</span></label>
                                <input type="file" class="filepond" name="image" id = "imageInput"  data-image="<?php echo e($blog->image); ?>">
                                <?php if($blog->image): ?>
                                <img id="preview" style="width:150px; border-radius:10px;" src="<?php echo e($blog->image); ?>">
                                <?php endif; ?>

                                <input type="hidden" id="existing_pond_file" name="existing_pond_file" value="<?php echo e($blog->image); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
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
<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/blog/edit.blade.php ENDPATH**/ ?>
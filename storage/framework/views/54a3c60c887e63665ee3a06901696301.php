<?php $__env->startPush('script'); ?>
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: true,
    allowReorder: true,
    acceptedFileTypes: ['image/*'],
    instantUpload: false,  // preview only, files are sent with the form
    storeAsFile: true,
    labelIdle: 'Add more images: drag &amp; drop or <span class="filepond--label-action">Browse</span>'
});

(function () {
    var list = document.getElementById('gallery-list');
    if (!list) return;

    function refresh() {
        var items = list.querySelectorAll('.gallery-row');
        var visible = 0;
        items.forEach(function (row, i) {
            var removed = row.querySelector('.remove-toggle').checked;
            row.classList.toggle('is-removed', removed);
            row.querySelector('.move-up').disabled = i === 0;
            row.querySelector('.move-down').disabled = i === items.length - 1;
            var badge = row.querySelector('.cover-badge');
            badge.hidden = removed || visible !== 0;
            if (!removed) visible++;
        });
    }

    list.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;
        var row = btn.closest('.gallery-row');
        if (btn.classList.contains('move-up') && row.previousElementSibling) {
            list.insertBefore(row, row.previousElementSibling);
        }
        if (btn.classList.contains('move-down') && row.nextElementSibling) {
            list.insertBefore(row.nextElementSibling, row);
        }
        refresh();
    });

    list.addEventListener('change', refresh);
    refresh();
})();
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
        <style>
            .gallery-list { list-style: none; padding: 0; margin: 0 0 12px; }
            .gallery-row { display: flex; align-items: center; gap: 12px; padding: 8px; margin-bottom: 8px; border: 1px solid #ebedf2; border-radius: 8px; background: #fff; transition: opacity .2s ease; }
            .gallery-row img { width: 64px; height: 80px; object-fit: cover; border-radius: 6px; flex: 0 0 auto; }
            .gallery-row .meta { flex: 1; min-width: 0; font-size: 13px; }
            .gallery-row .meta .name { display: block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #6c757d; }
            .gallery-row .actions { display: flex; align-items: center; gap: 4px; }
            .gallery-row.is-removed { opacity: .45; }
            .gallery-row.is-removed img { filter: grayscale(1); }
            .cover-badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 1px 8px; border-radius: 999px; background: var(--brand-primary, #212529); color: var(--brand-button-text, #FFD700); margin-bottom: 4px; }
        </style>

        <div class="col-md-8 col-lg-6">
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
                                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required value="<?php echo e(old('title', $blog->title)); ?>">
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="archivement">Description <span>*</span></label>
                                <textarea class="form-control" rows="4" placeholder="Enter Description of Blog" name="description"><?php echo e(old('description', $blog->description)); ?></textarea>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label>Images <span>*</span></label>
                                <small class="form-text text-muted mb-2 mt-0">The first image is the cover. Use the arrows to reorder, or tick Remove.</small>

                                <ul class="gallery-list" id="gallery-list">
                                    <?php $__currentLoopData = $blog->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="gallery-row">
                                        <input type="hidden" name="image_order[]" value="<?php echo e($image->id); ?>">
                                        <a href="<?php echo e($image->url); ?>" target="_blank" rel="noopener"><img src="<?php echo e($image->url); ?>" alt=""></a>
                                        <div class="meta">
                                            <span class="cover-badge" hidden>Cover</span>
                                            <span class="name"><?php echo e(basename($image->path)); ?></span>
                                        </div>
                                        <div class="actions">
                                            <button type="button" class="btn btn-sm btn-light move-up" title="Move up" aria-label="Move up"><i class="fas fa-arrow-up"></i></button>
                                            <button type="button" class="btn btn-sm btn-light move-down" title="Move down" aria-label="Move down"><i class="fas fa-arrow-down"></i></button>
                                            <label class="btn btn-sm btn-outline-danger mb-0 ms-1">
                                                <input type="checkbox" class="remove-toggle me-1" name="remove_images[]" value="<?php echo e($image->id); ?>"> Remove
                                            </label>
                                        </div>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                <input type="file" class="filepond" name="images[]" id="imageInput" multiple accept="image/jpeg,image/png,image/gif,image/webp">
                                <small class="form-text text-muted">New images are added after the ones above. JPG, PNG, GIF or WebP, up to 4 MB each, max <?php echo e(\App\Http\Controllers\admin\Blog\BlogController::maxImages); ?> images in total.</small>
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
<?php /**PATH C:\laragon\www\myresume\resources\views/admin/template1/blog/edit.blade.php ENDPATH**/ ?>
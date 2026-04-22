<?php $__env->startPush('script'); ?>
    <script>
    // This will create a single gallery from all elements that have class "gallery-item"
    $(document).ready(function () {
        $('#mytable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
        });
    });
    </script>
<?php $__env->stopPush(); ?>

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
            <div class="card-title">Inbox</div>
        </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="mytable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $inbox; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($data->name); ?></td>
                        <td><?php echo e($data->email); ?></td>
                        <td><?php echo e(\Illuminate\Support\Str::words($data->subject, 4, '...')); ?></td>
                        <td><?php echo e($data->created_at); ?></td>
                        <td>
                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm d-flex justify-content-center align-items-center">
                                <?php if(!$data->read_status): ?>
                                <li>
                                    <a class="nav-link btn btn-warning text-white"  href="<?php echo e(route('inbox.status',$data->id)); ?>">
                                        <i class="fas fa-envelope fa-lg "></i>
                                    </a>
                                </li>
                                <?php else: ?>
                                <li>
                                    <a class="nav-link btn btn-success text-white"  href="<?php echo e(route('inbox.status',$data->id)); ?>">
                                        <i class="fas fa-envelope-open fs-6 "></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <a class="nav-link btn btn-primary text-white"  href="<?php echo e(route('inbox.view.message',$data->id)); ?>">
                                        <i class="fas fa-eye fs-6 "></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link btn btn-danger text-white"  href="<?php echo e(route('inbox.delete',$data->id)); ?>">
                                        <i class="fas fa-trash fs-6 "></i>
                                    </a>
                                </li>
                            </ul>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
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
<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/inbox/index.blade.php ENDPATH**/ ?>
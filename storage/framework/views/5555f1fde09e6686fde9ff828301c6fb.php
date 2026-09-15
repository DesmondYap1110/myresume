<section class="resume-section p-3 p-lg-5 " id="project">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Project</h2>
        <div class="mb-5 heading-border"></div>
    </div>
    <?php $__currentLoopData = $project; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="resume-item col-md-6 col-sm-12 " >
        <div class="card mx-0 p-4 mb-5">
            <div class=" resume-content mr-auto">
                <h4 class="mb-3"><i class="fa fa-briefcase mr-3 text-info"></i> <?php echo e($data->company); ?> </h4>
                <h5> <?php echo e($data->name); ?></h5>

                <p> <?php echo e(strip_tags($data->detail)); ?></p>
            </div>
            <div class="resume-date text-md-right">
                <span class="text-primary"><?php echo e(date("F Y", strtotime($data->start_date))); ?> - <?php echo e(($data->end_date && $data->end_date != '1970-01-01') ? date("F Y", strtotime($data->end_date)) : 'Now'); ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</section>


<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/body/project.blade.php ENDPATH**/ ?>
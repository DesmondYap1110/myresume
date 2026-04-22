<section class="resume-section p-3 p-lg-5 d-flex flex-column justify-content-center align-items-center text-center" id="experience">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Experience</h2>
        <div class="mb-5 heading-border"></div>
        </div>
        <div class="main-experience" id="experience-box">
            <?php $__currentLoopData = $experience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="experience">
                <div class="experience-icon"></div>
                <div class="experience-content">
                    <span class="date"><?php echo e(date("F Y", strtotime($data->start_date))); ?> - <?php echo e(($data->end_date && $data->end_date != '1970-01-01') ? date("F Y", strtotime($data->end_date)) : 'Now'); ?></span>
                    <h3><?php echo e($data->company); ?></h3>
                    <h5 class="title"><?php echo e($data->role); ?></h5>
                    <p class="description">
                       <?php echo e(strip_tags($data->detail)); ?>

                    </p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/website/body/experience.blade.php ENDPATH**/ ?>
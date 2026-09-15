<section class="resume-section p-3 p-lg-5 " id="education">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Education</h2>
        <div class="mb-5 heading-border"></div>
    </div>
    <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="resume-item col-md-6 col-sm-12 " >
        <div class="card mx-0 p-4 mb-5">
            <div class=" resume-content mr-auto">
                <h4 class="mb-3"><i class="fa fa-graduation-cap mr-3 text-info"></i> <?php echo e($data->institution); ?> </h4>
                <h5> <?php echo e($data->certificate); ?></h5>

                <p> <?php echo e(strip_tags($data->achievement)); ?></p>
            </div>
            <div class="resume-date text-md-right">
                <span class="text-primary"><?php echo e($data->year); ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</section>


<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/body/education.blade.php ENDPATH**/ ?>
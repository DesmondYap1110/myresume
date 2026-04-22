
<script src="<?php echo e(asset('assets/website/js/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/website/js/bootstrap/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/website/js/jquery-easing/jquery.easing.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/website/js/counter/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/website/js/counter/jquery.counterup.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/website/js/custom.js')); ?>"></script>
<!-- Bootstrap Notify -->
<script src="<?php echo e(asset("assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js")); ?>"></script>
<script>
    $(document).ready(function(){

        $(".filter-b").click(function(){
            var value = $(this).attr('data-filter');
            if(value == "all")
            {
                $('.filter').show('1000');
            }
            else
            {
                $(".filter").not('.'+value).hide('3000');
                $('.filter').filter('.'+value).show('3000');
            }
        });

        if ($(".filter-b").removeClass("active"))
        {
            $(this).removeClass("active");
        }

        $(this).addClass("active");
    });

    // SKILLS
    $(function () {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });

    });
</script>

<script>
    $(document).ready(function () {

        <?php if(session('success')): ?>
            $.notify("<?php echo e(session('success')); ?>", "success");

        <?php endif; ?>

        <?php if(session('error')): ?>
            $.notify("<?php echo e(session('error')); ?>", "error");
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $.notify("<?php echo e($error); ?>", "error");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    });
</script>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/website/master/master-script.blade.php ENDPATH**/ ?>
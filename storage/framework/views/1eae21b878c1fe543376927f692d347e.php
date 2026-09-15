<!--   Core JS Files   -->
<script src="<?php echo e(asset("assets/admin/js/core/jquery-3.7.1.min.js" )); ?>"></script>
<script src="<?php echo e(asset("assets/admin/js/core/popper.min.js")); ?>"></script>
<script src="<?php echo e(asset("assets/admin/js/core/bootstrap.min.js")); ?>"></script>

<!-- jQuery Scrollbar -->
<script src="<?php echo e(asset("assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js")); ?>"></script>
<script src="<?php echo e(asset("assets/admin/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js")); ?>"></script>

<!-- Chart JS -->
<script src="<?php echo e(asset("assets/admin/js/plugin/chart.js/chart.min.js")); ?>"></script>

<!-- jQuery Sparkline -->
<script src="<?php echo e(asset("assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js")); ?>"></script>

<!-- Chart Circle -->
<script src="<?php echo e(asset("assets/admin/js/plugin/chart-circle/circles.min.js")); ?>"></script>

<!-- Datatables -->
<script src="<?php echo e(asset("assets/admin/js/plugin/datatables/datatables.min.js")); ?>"></script>

<!-- Bootstrap Notify -->
<script src="<?php echo e(asset("assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js")); ?>"></script>

<!-- jQuery Vector Maps -->
<script src="<?php echo e(asset("assets/admin/js/plugin/jsvectormap/jsvectormap.min.js")); ?>"></script>
<script src="<?php echo e(asset("assets/admin/js/plugin/jsvectormap/world.js")); ?>"></script>

<!-- Sweet Alert -->
<script src="<?php echo e(asset("assets/admin/js/plugin/sweetalert/sweetalert.min.js")); ?>"></script>

<!-- Kaiadmin JS -->
<script src="<?php echo e(asset("assets/admin/js/kaiadmin.min.js")); ?>"></script>

<!-- Fonts and icons -->
<script src="<?php echo e(asset("assets/admin/js/plugin/webfont/webfont.min.js")); ?>"></script>

<!-- Moment JS -->
<script src="<?php echo e(asset("assets/admin/js/plugin/moment/moment.min.js")); ?>"></script>

<script>
    WebFont.load({
    google: { families: ["Public Sans:300,400,500,600,700"] },
    custom: {
        families: [
        "Font Awesome 5 Solid",
        "Font Awesome 5 Regular",
        "Font Awesome 5 Brands",
        "simple-line-icons",
        ],
        urls: ["<?php echo e(asset('assets/admin/css/fonts.min.css')); ?>"]
    },
    active: function () {
        sessionStorage.fonts = true;
    },
    });
</script>

<!-- DateTimePicker -->
<script src="<?php echo e(asset("assets/admin/js/plugin/datepicker/bootstrap-datetimepicker.min.js")); ?>"></script>

<!-- Select2 -->
<script src="<?php echo e(asset("assets/admin/js/plugin/select2/select2.full.min.js")); ?>"></script>

<!-- Summer Note-->
<script src="<?php echo e(asset("assets/admin/js/plugin/summernote/summernote-lite.min.js")); ?>"></script>

<!-- Date Picker-->
<script src="<?php echo e(asset('assets/admin/js/plugin/datepicker/bootstrap-datepicker.min.js')); ?>"></script>

<!-- File Pond-->
<script src="<?php echo e(asset('assets/admin/js/plugin/filepond/filepond.min.js')); ?>"></script>

<script>
    $('#datetime').datetimepicker({
        format: 'MM/DD/YYYY H:mm',
    });

    $('#datepicker').datetimepicker({
        format: 'MM/DD/YYYY',
    });

    $('#timepicker').datetimepicker({
        format: 'h:mm A',
    });

    $('#basic').select2({
        theme: "bootstrap"
    });

    $('#multiple').select2({
        theme: "bootstrap"
    });

    $('#multiple-states').select2({
        theme: "bootstrap"
    });

    $('#summernote').summernote({
        placeholder: $('.summertext').data('placeholder'),
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
        tabsize: 2,
        height: 300
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


<?php echo $__env->yieldPushContent('script'); ?>
<?php /**PATH C:\laragon\www\my-portfolio\resources\views/components/template1/admin/master/master-script.blade.php ENDPATH**/ ?>
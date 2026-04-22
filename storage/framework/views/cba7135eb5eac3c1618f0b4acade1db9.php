<?php
    $companyname = "Adrian";
    $powerby = "Desmond";
?>

<footer class="footer fixed-bottom position-fixed bg-light">
    <div class="container d-flex flex-row-reverse">
        <div class="copyright">
            © Copyright <?php echo e(date("Y")." ".$companyname); ?>. All Rights Reserved.
        </div>
        <div>
            Powered by <?php echo e($powerby); ?>

        </div>
    </div>
</footer>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/admin/footer/footer-main.blade.php ENDPATH**/ ?>
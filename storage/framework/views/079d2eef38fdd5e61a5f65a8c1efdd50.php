
<div aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden">
    <label for="<?php echo e(\App\Support\SpamGuard::honeypot); ?>">Leave this field empty</label>
    <input type="text" id="<?php echo e(\App\Support\SpamGuard::honeypot); ?>" name="<?php echo e(\App\Support\SpamGuard::honeypot); ?>" value="" tabindex="-1" autocomplete="off">
</div>
<input type="hidden" name="<?php echo e(\App\Support\SpamGuard::timestamp); ?>" value="<?php echo e(\App\Support\SpamGuard::token()); ?>">
<?php /**PATH C:\laragon\www\myresume\resources\views/components/website/form-guard.blade.php ENDPATH**/ ?>
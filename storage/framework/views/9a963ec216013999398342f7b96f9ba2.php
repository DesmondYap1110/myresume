<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['label' => null, 'class' => 'form-control', 'theme' => 'auto']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['label' => null, 'class' => 'form-control', 'theme' => 'auto']); ?>
<?php foreach (array_filter((['label' => null, 'class' => 'form-control', 'theme' => 'auto']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php $driver = \App\Support\Captcha::driver(); ?>

<?php if($driver === 'turnstile'): ?>
    <div class="cf-turnstile"
         data-sitekey="<?php echo e(config('captcha.turnstile.site_key')); ?>"
         data-theme="<?php echo e($theme); ?>"></div>
    <?php if (! $__env->hasRenderedOnce('fad7c37b-f2a5-43e4-88d9-449829e3f481')): $__env->markAsRenderedOnce('fad7c37b-f2a5-43e4-88d9-449829e3f481'); ?>
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <?php endif; ?>
    <?php $__errorArgs = ['captcha_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger d-block"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<?php elseif($driver === 'math'): ?>
    <?php $captcha = \App\Support\Captcha::question(); ?>
    <label for="<?php echo e(\App\Support\Captcha::field); ?>"><?php echo e($label ?? 'Quick check'); ?>: <?php echo e($captcha['question']); ?> <span aria-hidden="true">*</span></label>
    <input type="text" class="<?php echo e($class); ?>" id="<?php echo e(\App\Support\Captcha::field); ?>" name="<?php echo e(\App\Support\Captcha::field); ?>"
           inputmode="numeric" autocomplete="off" required
           placeholder="Type the number"
           aria-label="<?php echo e($captcha['question']); ?>">
    <?php $__errorArgs = [\App\Support\Captcha::field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="text-danger d-block"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/website/captcha.blade.php ENDPATH**/ ?>
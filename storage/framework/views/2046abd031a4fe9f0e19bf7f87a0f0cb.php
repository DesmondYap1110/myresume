<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user', 'title' => null, 'home' => '']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user', 'title' => null, 'home' => '']); ?>
<?php foreach (array_filter((['user', 'title' => null, 'home' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $asset = fn ($path) => asset('assets/website/template2/'.$path);
    $version = @filemtime(public_path('assets/website/template2/css/custom.css'));
    $links = [
        'about' => 'About',
        'experience' => 'Experience',
        'education' => 'Education',
        'projects' => 'Projects',
        'blog' => 'Blog',
        'contact' => 'Contact',
    ];
    $first = trim(explode(' ', trim((string) $user->name))[0] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ? $title.' | '.$user->name : $user->name.($user->role ? ' - '.$user->role : '')); ?></title>
    <meta name="description" content="<?php echo e(\Illuminate\Support\Str::limit(strip_tags((string) $user->about), 155)); ?>">
    <link rel="icon" href="<?php echo e(asset('assets/admin/img/kaiadmin/favicon.ico')); ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo e($asset('plugins/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/themify/css/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/aos/aos.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/owl-carousel/owl.carousel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/owl-carousel/owl.theme.default.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/animated-text/animated-text.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('css/custom.css')); ?>?v=<?php echo e($version); ?>">
</head>

<body class="t2">

<nav class="navbar navbar-expand-lg main-nav" id="navbar">
    <div class="container">
        <a class="navbar-brand t2-brand" href="<?php echo e($home ?: '#top'); ?>"><?php echo e($first ?: $user->name); ?><span>.</span></a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#t2-nav" aria-controls="t2-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-align-justify"></span>
        </button>

        <div class="collapse navbar-collapse" id="t2-nav">
            <ul class="navbar-nav ml-auto">
                <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anchor => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo e($home); ?>#<?php echo e($anchor); ?>"><?php echo e($label); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</nav>

<main id="top">
    <?php echo e($slot); ?>

</main>

<section class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> <span class="text-white"><?php echo e($user->name); ?></span>. All rights reserved.
                    <br><small>Template: <a target="_blank" rel="noopener" href="https://themefisher.com" class="text-white">Thomson by Themefisher</a>, distributed by <a target="_blank" rel="noopener" href="https://themewagon.com" class="text-white">ThemeWagon</a></small>
                </p>
            </div>
            <div class="col-lg-6">
                <div class="widget footer-widget text-lg-right mt-4 mt-lg-0">
                    <ul class="list-inline mb-0">
                        <?php if($user->linkedIn_url): ?>
                        <li class="list-inline-item"><a href="<?php echo e($user->linkedIn_url); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="ti-linkedin mr-3"></i></a></li>
                        <?php endif; ?>
                        <?php if($user->email): ?>
                        <li class="list-inline-item"><a href="mailto:<?php echo e($user->email); ?>" aria-label="Email"><i class="ti-email mr-3"></i></a></li>
                        <?php endif; ?>
                        <?php if($user->phone): ?>
                        <li class="list-inline-item"><a href="https://wa.me/<?php echo e($user->phone); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="ti-mobile mr-3"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo e($asset('plugins/jQuery/jquery.min.js')); ?>"></script>
<script src="<?php echo e($asset('plugins/bootstrap/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e($asset('plugins/aos/aos.js')); ?>"></script>
<script src="<?php echo e($asset('plugins/owl-carousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e($asset('plugins/animated-text/animated-text.js')); ?>"></script>
<script src="<?php echo e($asset('js/template2.js')); ?>?v=<?php echo e(@filemtime(public_path('assets/website/template2/js/template2.js'))); ?>"></script>
<?php echo $__env->yieldPushContent('t2-scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template2/website/master/master-layout.blade.php ENDPATH**/ ?>
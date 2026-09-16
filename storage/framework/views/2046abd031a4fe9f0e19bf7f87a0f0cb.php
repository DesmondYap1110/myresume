<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null]); ?>
<?php foreach (array_filter((['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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
    $links = $sections ?: [
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
    <?php if (isset($component)) { $__componentOriginalddf8eec87a3172e652805bac126d7ed0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalddf8eec87a3172e652805bac126d7ed0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.website.seo','data' => ['user' => $user,'post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('website.seo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalddf8eec87a3172e652805bac126d7ed0)): ?>
<?php $attributes = $__attributesOriginalddf8eec87a3172e652805bac126d7ed0; ?>
<?php unset($__attributesOriginalddf8eec87a3172e652805bac126d7ed0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalddf8eec87a3172e652805bac126d7ed0)): ?>
<?php $component = $__componentOriginalddf8eec87a3172e652805bac126d7ed0; ?>
<?php unset($__componentOriginalddf8eec87a3172e652805bac126d7ed0); ?>
<?php endif; ?>
    <link rel="icon" href="<?php echo e(asset('assets/admin/img/kaiadmin/favicon.ico')); ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo e($asset('plugins/bootstrap/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/themify/css/themify-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/aos/aos.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/owl-carousel/owl.carousel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/owl-carousel/owl.theme.default.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('plugins/animated-text/animated-text.css')); ?>">
    <link rel="stylesheet" href="<?php echo e($asset('css/style.css')); ?>">
    
    <style>
        :root {
            <?php echo \App\Support\Branding::cssDeclarations(\App\Support\Branding::websiteCssVariables($user, 'template2')); ?>

        }
    </style>
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

<footer class="t2-footer">
    <div class="container">
        <div class="row t2-footer-main">
            
            <div class="col-lg-4 col-md-12 mb-5 mb-lg-0">
                <a class="t2-footer-brand" href="<?php echo e($home ?: '#top'); ?>"><?php echo e($first ?: $user->name); ?><span>.</span></a>
                <?php if($user->role): ?>
                <p class="t2-footer-role"><?php echo e($user->role); ?></p>
                <?php endif; ?>
                <p class="t2-footer-about"><?php echo e(\Illuminate\Support\Str::limit(trim(strip_tags((string) $user->about)), 150)); ?></p>
                <ul class="list-inline t2-social mb-0">
                    <?php if($user->linkedIn_url): ?>
                    <li class="list-inline-item"><a href="<?php echo e($user->linkedIn_url); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="ti-linkedin"></i></a></li>
                    <?php endif; ?>
                    <?php if($user->email): ?>
                    <li class="list-inline-item"><a href="mailto:<?php echo e($user->email); ?>" aria-label="Email"><i class="ti-email"></i></a></li>
                    <?php endif; ?>
                    <?php if($user->phone): ?>
                    <li class="list-inline-item"><a href="https://wa.me/<?php echo e($user->phone); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="ti-mobile"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            
            <div class="col-lg-2 col-md-4 col-6 mb-5 mb-lg-0">
                <h5 class="t2-footer-title">Explore</h5>
                <ul class="list-unstyled t2-footer-links">
                    <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anchor => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e($home); ?>#<?php echo e($anchor); ?>"><?php echo e($label); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            
            <div class="col-lg-3 col-md-4 col-6 mb-5 mb-lg-0">
                <h5 class="t2-footer-title">Latest Posts</h5>
                <?php if(count($blog)): ?>
                <ul class="list-unstyled t2-footer-posts">
                    <?php $__currentLoopData = collect($blog)->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('front.post', [$item->id, request()->id])); ?>"><?php echo e($item->title); ?></a>
                        <span><?php echo e($item->created_at->format('d M Y')); ?></span>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php else: ?>
                <p class="t2-footer-about">New posts are on the way.</p>
                <?php endif; ?>
            </div>

            
            <div class="col-lg-3 col-md-4">
                <h5 class="t2-footer-title">Get in Touch</h5>
                <ul class="list-unstyled t2-footer-contact">
                    <?php if($user->address): ?>
                    <li><i class="ti-location-pin"></i><span><?php echo e($user->address); ?></span></li>
                    <?php endif; ?>
                    <?php if($user->email): ?>
                    <li><i class="ti-email"></i><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></li>
                    <?php endif; ?>
                    <?php if($user->phone): ?>
                    <li><i class="ti-mobile"></i><a href="https://wa.me/<?php echo e($user->phone); ?>" target="_blank" rel="noopener">+<?php echo e($user->phone); ?></a></li>
                    <?php endif; ?>
                </ul>
                <a href="<?php echo e($home); ?>#contact" class="btn btn-main btn-sm mt-2">Let's work together</a>
            </div>
        </div>

        <div class="t2-footer-bottom">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> <span><?php echo e($user->name); ?></span>. All rights reserved.</p>
            <a href="#top" class="t2-to-top" aria-label="Back to top">Back to top <i class="ti-arrow-up"></i></a>
        </div>
    </div>
</footer>

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
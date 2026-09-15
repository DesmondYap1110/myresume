<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">

    <?php if($user->image): ?>
    <span class="d-none d-lg-block">
        <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="<?php echo e($user->image); ?>" alt="<?php echo e($user->name); ?>">
    </span>
    <span class="d-lg-none brand-name"><?php echo e($user->name); ?></span>
    <?php else: ?>
    <?php
        $initials = collect(preg_split('/\s+/', trim((string) $user->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    ?>
    <span class="img-profile profile-initials d-none d-lg-flex mx-auto mb-2"><?php echo e($initials); ?></span>
    <span class="d-lg-none brand-name"><?php echo e($user->name); ?></span>
    <?php endif; ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>

            <?php if(count($education)!=0): ?>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#education">Education</a>
            </li>
            <?php endif; ?>

            <?php if(count($experience)!=0): ?>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#experience">Experience</a>
            </li>
            <?php endif; ?>

            <?php if(count($project)!=0): ?>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#project">Project</a>
            </li>
            <?php endif; ?>

            <?php if(count($blog)!=0): ?>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#blog">Blog</a>
            </li>
             <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
        </ul>
    </div>
</nav>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/navbar/navbar.blade.php ENDPATH**/ ?>
<?php
    // Words for the terminal typing line: the roles from Experience, else a default set.
    $words = collect($experience ?? [])->pluck('role')->filter()->map(fn ($r) => trim(strip_tags($r)))->unique()->values()->all();
    $words = array_values(array_unique(array_merge($words, ['Web Developer', 'Problem Solver', 'Building things for the web'])));
?>
<section class="resume-section p-3 p-lg-5 d-flex flex-column justify-content-center align-items-center text-center" id="about">
    
    <canvas class="hero-network" aria-hidden="true"></canvas>
    <div class="hero-scan" aria-hidden="true"></div>
    <div class="hero-floaters" aria-hidden="true">
        <i class="devicons devicons-php"></i>
        <i class="devicons devicons-laravel"></i>
        <i class="devicons devicons-javascript"></i>
        <i class="devicons devicons-html5"></i>
        <i class="devicons devicons-css3"></i>
        <i class="devicons devicons-mysql"></i>
        <i class="devicons devicons-git"></i>
        <i class="devicons devicons-jquery"></i>
        <i class="devicons devicons-bootstrap"></i>
        <i class="devicons devicons-terminal"></i>
    </div>
    <div class="hero-hud" aria-hidden="true">
        <span class="hud-corner tl"></span><span class="hud-corner tr"></span>
        <span class="hud-corner bl"></span><span class="hud-corner br"></span>
    </div>

    <div class="my-auto">

        <div class="hero-kicker"><span class="status-dot"></span> &lt;hello world /&gt;</div>

        <h1 class="mb-0 glitch" data-text="<?php echo e($user->name); ?>"><?php echo e($user->name); ?></h1>

        <div class="subheading mb-5 hero-terminal">
            <span class="prompt">~$</span>
            <span class="typed" data-words='<?php echo json_encode($words, 15, 512) ?>'><?php echo e($words[0]); ?></span><span class="caret"></span>
        </div>

        <?php if(trim(strip_tags((string) $user->about)) !== ''): ?>
        <p class="mb-5" style="max-width: 560px; text-align: justify;">
            <?php echo e(strip_tags($user->about)); ?>

        </p>
        <?php endif; ?>

        <ul class="list-inline list-social-icons mb-0">
            <?php if($user->email): ?>
            <li class="list-inline-item">
                <a href="mailto:<?php echo e($user->email); ?>" target="_blank">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($user->phone): ?>
            <li class="list-inline-item">
                <a href="https://wa.me/<?php echo e($user->phone); ?>?text=Hello%20I%20want%20to%20contact%20you" target="_blank">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-whatsapp fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($user->linkedIn_url): ?>
            <li class="list-inline-item">
                <a href="<?php echo e($user->linkedIn_url); ?>" target="_blank">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <a href="#<?php echo e(count($education ?? []) ? 'education' : 'contact'); ?>" class="hero-scroll js-scroll-trigger" aria-label="Scroll down">
            <span class="mouse"><span class="wheel"></span></span>
        </a>

    </div>
</section>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/website/body/about.blade.php ENDPATH**/ ?>
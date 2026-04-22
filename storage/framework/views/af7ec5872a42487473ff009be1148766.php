<section class="resume-section p-3 p-lg-5 d-flex flex-column justify-content-center align-items-center text-center" id="about">
    <div class="my-auto">

        <div class="img-fluid mb-3 bg-light"></div>

        <h1 class="mb-0"><?php echo e($user->name); ?></h1>

        <div class="subheading mb-5"></div>

        <p class="mb-5" style="max-width: 500px; color:black; text-align: justify;">
            <?php echo e(strip_tags($user->about)); ?>

        </p>

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

    </div>
</section>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/website/body/about.blade.php ENDPATH**/ ?>
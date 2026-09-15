<li class="nav-item <?php echo e(request()->routeIs($link) ? 'active' : ''); ?>">

    <?php if($link === 'login.logout'): ?>
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="<?php echo e($icon); ?>"></i>
            <p><?php echo e($title); ?></p>
        </a>

        <form id="logout-form" action="<?php echo e(route('login.logout')); ?>" method="POST" style="display:none;">
            <?php echo csrf_field(); ?>
        </form>

    <?php else: ?>
        <a href="<?php echo e(route($link)); ?>">

            <i class="<?php echo e($icon); ?>"></i>
            <p><?php echo e($title); ?></p>

            <?php if($notification == "true"): ?>
                <span class="badge badge-secondary"><?php echo e($count); ?></span>
            <?php endif; ?>

        </a>
    <?php endif; ?>

</li>
<?php /**PATH C:\laragon\www\my-portfolio\resources\views/components/template1/admin/sidebar/ui/list.blade.php ENDPATH**/ ?>
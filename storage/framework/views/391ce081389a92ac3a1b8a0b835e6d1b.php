<?php
    // Sidebar Setting
    $menus = [
        [
            'isDropdown' => false,
            'link' => "dashboard.view",
            'icon' => "fas fa-tachometer-alt",
            'title' => "Dashboard",
            'count' => 5,
            'notification' => false
        ],

        [
            'isDropdown' => true,
            'icon' => "fas fa-user-circle",
            'title' => "My Profile",
            'menulist' => [
                ["url" => "profile.view", "text" => "Profile"],
                ["url" => "education.view", "text" => "Education"],
                ["url" => "experience.view", "text" => "Experience"],
                ["url" => "project.view", "text" => "Project"],
                ["url" => "blog.view", "text" => "Blog"],
            ]
        ],

        [
            'isDropdown' => false,
            'link' => "inbox.view",
            'icon' => "fas fa-envelope",
            'title' => "Inbox",
            'count' => count(\App\Models\Inbox::getInboxByUseridStatus(Auth::user()->id)),
            'notification' => true
        ],

        [
            'isDropdown' => false,
            'link' => "setting.view",
            'icon' => "fas fa-cog",
            'title' => "Account Setting",
            'count' => 0,
            'notification' => false
        ],

        [
            'isDropdown' => false,
            'link' => "login.logout",
            'icon' => "fas fa-sign-out-alt",
            'title' => "Log Out",
            'count' => 0,
            'notification' => false
        ]
    ];
?>

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark" style="z-index: 2000;">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
        <a href="<?php echo e(route("dashboard.view")); ?>" class="logo">
            <img
            src="<?php echo e(asset("assets/admin/img/kaiadmin/logo_dark.png")); ?>"
            alt="navbar brand"
            class="navbar-brand"
            height="110px"
            width="100%"
            />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($menu['isDropdown']) && $menu['isDropdown'] == true): ?>
                        <?php if (isset($component)) { $__componentOriginalb9264cbcf99da8b4e3286c6e7237a935 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9264cbcf99da8b4e3286c6e7237a935 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.sidebar.ui.dropdown','data' => ['menulist' => $menu['menulist'],'icon' => $menu['icon'],'title' => $menu['title']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.sidebar.ui.dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menulist' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['menulist']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['icon']),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['title'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9264cbcf99da8b4e3286c6e7237a935)): ?>
<?php $attributes = $__attributesOriginalb9264cbcf99da8b4e3286c6e7237a935; ?>
<?php unset($__attributesOriginalb9264cbcf99da8b4e3286c6e7237a935); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9264cbcf99da8b4e3286c6e7237a935)): ?>
<?php $component = $__componentOriginalb9264cbcf99da8b4e3286c6e7237a935; ?>
<?php unset($__componentOriginalb9264cbcf99da8b4e3286c6e7237a935); ?>
<?php endif; ?>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal003ea08d1a966572dc12569ee90ae369 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal003ea08d1a966572dc12569ee90ae369 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.sidebar.ui.list','data' => ['link' => $menu['link'],'icon' => $menu['icon'],'title' => $menu['title'],'count' => $menu['count'] ?? 0,'notification' => $menu['notification'] ?? 'none']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.sidebar.ui.list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['link']),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['icon']),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['title']),'count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['count'] ?? 0),'notification' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu['notification'] ?? 'none')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal003ea08d1a966572dc12569ee90ae369)): ?>
<?php $attributes = $__attributesOriginal003ea08d1a966572dc12569ee90ae369; ?>
<?php unset($__attributesOriginal003ea08d1a966572dc12569ee90ae369); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal003ea08d1a966572dc12569ee90ae369)): ?>
<?php $component = $__componentOriginal003ea08d1a966572dc12569ee90ae369; ?>
<?php unset($__componentOriginal003ea08d1a966572dc12569ee90ae369); ?>
<?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/admin/sidebar/sidebar-main.blade.php ENDPATH**/ ?>
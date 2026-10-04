@php
    // Sidebar Setting
    $menus = [
        [
            'isDropdown' => false,
            'link' => "dashboard.view",
            'icon' => "fas fa-tachometer-alt",
            'title' => __('admin.menu.dashboard'),
            'count' => 5,
            'notification' => false
        ],

        [
            'isDropdown' => true,
            'icon' => "fas fa-user-circle",
            'title' => __('admin.menu.my_profile'),
            'menulist' => [
                ["url" => "profile.view", "text" => __('admin.menu.profile')],
                ["url" => "education.view", "text" => __('admin.menu.education')],
                ["url" => "experience.view", "text" => __('admin.menu.experience')],
                ["url" => "project.view", "text" => __('admin.menu.project')],
                ["url" => "skill.view", "text" => __('admin.menu.skill')],
                ["url" => "service.view", "text" => __('admin.menu.service')],
                ["url" => "testimonial.view", "text" => __('admin.menu.testimonial')],
                ["url" => "blog.view", "text" => __('admin.menu.blog')],
            ]
        ],

        // Hidden until an administrator has set this account up under AI Setting.
        ...(($aiReady ?? false) ? [[
            'isDropdown' => false,
            'link' => "ai.view",
            'icon' => "fas fa-robot",
            'title' => __('admin.menu.ai_assistant'),
            'count' => 0,
            'notification' => false
        ]] : []),

        [
            'isDropdown' => false,
            'link' => "visitor.view",
            'icon' => "fas fa-map-marker-alt",
            'title' => __('admin.menu.visitor'),
            'count' => 0,
            'notification' => false
        ],

        [
            'isDropdown' => false,
            'link' => "inbox.view",
            'icon' => "fas fa-envelope",
            'title' => __('admin.menu.inbox'),
            'count' => count($inboxUnread),
            'notification' => true
        ],

        // Site administration, not one person's portfolio.
        ...(Auth::user()->isAdmin() ? [[
            'isDropdown' => false,
            'link' => "member.view",
            'icon' => "fas fa-users",
            'title' => __('admin.menu.member'),
            'count' => 0,
            'notification' => false
        ], [
            'isDropdown' => false,
            'link' => "aisetting.view",
            'icon' => "fas fa-key",
            'title' => __('admin.menu.ai_setting'),
            'count' => 0,
            'notification' => false
        ]] : []),

        [
            'isDropdown' => false,
            'link' => "setting.view",
            'icon' => "fas fa-cog",
            'title' => __('admin.menu.account_setting'),
            'count' => 0,
            'notification' => false
        ],

        [
            'isDropdown' => false,
            'link' => "login.logout",
            'icon' => "fas fa-sign-out-alt",
            'title' => __('admin.menu.logout'),
            'count' => 0,
            'notification' => false
        ]
    ];
@endphp

<!-- Sidebar -->
<div class="sidebar" data-background-color="dark" style="z-index: 2000;">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
        <a href="{{route("dashboard.view")}}" class="logo">
            <img
            src="{{ asset("assets/admin/img/kaiadmin/logo_dark.png")}}"
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

                @foreach ($menus as $menu)
                    @if(isset($menu['isDropdown']) && $menu['isDropdown'] == true)
                        <x-template1.admin.sidebar.ui.dropdown
                            :menulist="$menu['menulist']"
                            :icon="$menu['icon']"
                            :title="$menu['title']"
                        />
                    @else
                        <x-template1.admin.sidebar.ui.list
                            :link="$menu['link']"
                            :icon="$menu['icon']"
                            :title="$menu['title']"
                            :count="$menu['count'] ?? 0"
                            :notification="$menu['notification'] ?? 'none'"
                        />
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

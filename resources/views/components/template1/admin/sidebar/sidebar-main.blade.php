@php
    // Sidebar Setting
    $menus = [
        [
            'isDropdown' => false,
            'link' => route("dashboard.view"),
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
                ["url" =>  route("profile.view"), "text" => "Profile"],
                ["url" => "", "text" => "text2"],
            ]
        ],

        [
            'isDropdown' => false,
            'link' => "/home",
            'icon' => "fas fa-envelope",
            'title' => "Inbox",
            'count' => 5,
            'notification' => false
        ],

        [
            'isDropdown' => false,
            'link' => route("setting.view"),
            'icon' => "fas fa-cog",
            'title' => "Account Setting",
            'count' => 0,
            'notification' => false
        ],

        [
            'isDropdown' => false,
            'link' => "/home",
            'icon' => "fas fa-sign-out-alt",
            'title' => "Log Out",
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
            src="{{ asset("assets/admin/img/kaiadmin/logo_light.svg")}}"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
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

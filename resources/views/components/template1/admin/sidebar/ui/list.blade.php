<li class="nav-item {{ request()->routeIs($link) ? 'active' : '' }}">
    <a href="{{ route($link) }}">
        <i class="{{ $icon }}"></i>
        <p>{{ $title }}</p>
        @if($notification == "true")
        <span class="badge badge-secondary">{{ $count }}</span>
        @endif
    </a>
</li>

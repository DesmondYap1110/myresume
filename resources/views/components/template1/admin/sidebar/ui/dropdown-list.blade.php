<li {{ request()->routeIs($url) ? 'active' : '' }}>
    <a href="{{ route($url) }}">
    <span class="sub-item">{{ $text }}</span>
    </a>
</li>

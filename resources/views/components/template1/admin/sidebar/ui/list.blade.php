<li class="nav-item {{ request()->routeIs($link) ? 'active' : '' }}">

    @if($link === 'login.logout')
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="{{ $icon }}"></i>
            <p>{{ $title }}</p>
        </a>

        <form id="logout-form" action="{{ route('login.logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

    @else
        <a href="{{ route($link) }}">

            <i class="{{ $icon }}"></i>
            <p>{{ $title }}</p>

            @if($notification == "true")
                <span class="badge badge-secondary" @if($link === 'inbox.view') id="sidebarInboxBadge" @endif @if(!$count) style="display:none" @endif>{{ $count }}</span>
            @endif

        </a>
    @endif

</li>

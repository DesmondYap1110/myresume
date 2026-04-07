<li class="nav-item">
    <a href="{{ $link }}">
        <i class="{{ $icon }}"></i>
        <p>{{ $title }}</p>
        @if($notification == "true")
        <span class="badge badge-secondary">{{ $count }}</span>
        @endif
    </a>
</li>

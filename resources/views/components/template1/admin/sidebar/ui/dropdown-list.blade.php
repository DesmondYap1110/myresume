@if(request()->routeIs($url))
 @push('show')
    'show'
 @endpush
 @endif
<li class="{{ request()->routeIs($url) ? 'active' : '' }}">
    <a href="{{ route($url) }}">
    <span class="sub-item">{{ $text }}</span>
    </a>
</li>



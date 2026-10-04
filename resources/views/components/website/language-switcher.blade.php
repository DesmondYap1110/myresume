@php
    $locales = (array) config('locales.supported', []);
    $current = app()->getLocale();
@endphp

@if(count($locales) > 1)
<div class="lang-switch" role="group" aria-label="{{ __('site.label.language') }}">
    @foreach($locales as $code => $locale)
        @if($code === $current)
            <span class="lang-switch-item is-active" aria-current="true">{{ $locale['flag'] ?? strtoupper($code) }}</span>
        @else
            {{-- Keeps whatever else is on the address, so switching language
                 on a blog post stays on that post. --}}
            <a class="lang-switch-item"
               href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}"
               hreflang="{{ $code }}"
               title="{{ $locale['native'] ?? $code }}"
               rel="nofollow">{{ $locale['flag'] ?? strtoupper($code) }}</a>
        @endif
    @endforeach
</div>

<style>
    .lang-switch {
        position: fixed; top: 14px; right: 14px; z-index: 1080;
        display: flex; gap: 2px; padding: 3px; border-radius: 999px;
        background: rgba(20, 20, 22, .72); backdrop-filter: blur(6px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, .18);
    }
    .lang-switch-item {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 34px; height: 28px; padding: 0 9px; border-radius: 999px;
        font-size: 12px; font-weight: 700; line-height: 1; letter-spacing: .02em;
        color: rgba(255, 255, 255, .78); text-decoration: none;
        transition: background-color .15s ease, color .15s ease;
    }
    .lang-switch-item:hover { background: rgba(255, 255, 255, .14); color: #fff; text-decoration: none; }
    .lang-switch-item.is-active { background: var(--brand-accent, #FFD700); color: var(--brand-sidebar, #141416); }

    @media (max-width: 575px) {
        .lang-switch { top: 8px; right: 8px; padding: 2px; }
        .lang-switch-item { min-width: 30px; height: 26px; padding: 0 7px; font-size: 11px; }
    }

    @media print { .lang-switch { display: none; } }
</style>
@endif

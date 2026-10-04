@php
    // Words for the terminal typing line: the roles from Experience, else a default set.
    // Short titles only, so the typing line stays on one line.
    $words = \App\Support\RoleLabel::headlineWords($experience ?? [], $user->t('role'));
@endphp
<section class="resume-section p-3 p-lg-5 d-flex flex-column justify-content-center align-items-center text-center" id="about">
    {{-- Decorative tech layers, animated by assets/website/js/theme.js --}}
    <canvas class="hero-network" aria-hidden="true"></canvas>
    <div class="hero-scan" aria-hidden="true"></div>
    <div class="hero-floaters" aria-hidden="true">
        <i class="devicons devicons-php"></i>
        <i class="devicons devicons-laravel"></i>
        <i class="devicons devicons-javascript"></i>
        <i class="devicons devicons-html5"></i>
        <i class="devicons devicons-css3"></i>
        <i class="devicons devicons-mysql"></i>
        <i class="devicons devicons-git"></i>
        <i class="devicons devicons-jquery"></i>
        <i class="devicons devicons-bootstrap"></i>
        <i class="devicons devicons-terminal"></i>
    </div>
    <div class="hero-hud" aria-hidden="true">
        <span class="hud-corner tl"></span><span class="hud-corner tr"></span>
        <span class="hud-corner bl"></span><span class="hud-corner br"></span>
    </div>

    <div class="my-auto">

        <div class="hero-kicker"><span class="status-dot"></span> &lt;hello world /&gt;</div>

        <h1 class="mb-0 glitch" data-text="{{ $user->name }}">{{ $user->name }}</h1>

        {{-- Nothing to type for somebody with no role and no experience yet. --}}
        @if($words)
        <div class="subheading mb-5 hero-terminal">
            <span class="prompt">~$</span>
            <span class="typed" data-words='@json($words)'>{{ $words[0] }}</span><span class="caret"></span>
        </div>
        @endif

        @if(trim(strip_tags((string) $user->t('about'))) !== '')
        <p class="mb-5" style="max-width: 560px; text-align: justify;">
            {{ strip_tags($user->t('about')) }}
        </p>
        @endif

        {{-- Email, then whatever is switched on under Profile > Social Links.
             WhatsApp is one of those rows now, so it is not repeated here. --}}
        <ul class="list-inline hero-social mb-0">
            @if($user->email)
            <li class="list-inline-item">
                <a href="mailto:{{ $user->email }}" title="{{ __('site.label.email') }}" aria-label="{{ __('site.label.email') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="currentColor" aria-hidden="true">
                        <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.24-8 4.75-8-4.75V6l8 4.75L20 6z"/>
                    </svg>
                </a>
            </li>
            @endif

            @foreach($user->socialLinks() as $link)
            <li class="list-inline-item">
                <a href="{{ $link['url'] }}" target="_blank" rel="noopener me"
                   title="{{ $link['label'] }}" aria-label="{{ $link['label'] }}">
                    <x-social-icon :network="$link" :size="17" tone="current" />
                </a>
            </li>
            @endforeach
        </ul>

        <style>
            /* Round badges drawn here rather than with fa-stack, which can
               only position a font glyph, not an SVG. The icons inherit the
               hero's own text colour so they stay visible on the dark panel. */
            .hero-social { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; padding: 0; }
            .hero-social .list-inline-item { margin: 0; }
            .hero-social a {
                display: inline-flex; align-items: center; justify-content: center;
                width: 44px; height: 44px; border-radius: 50%;
                border: 1px solid rgba(255, 255, 255, .28);
                color: #fff; background: rgba(255, 255, 255, .06);
                transition: background-color .2s ease, border-color .2s ease, transform .2s ease;
            }
            .hero-social a:hover {
                background: var(--brand-accent, #FFD700);
                border-color: var(--brand-accent, #FFD700);
                color: var(--brand-sidebar, #141416);
                transform: translateY(-2px);
            }
        </style>

        @if($user->hasResume())
        <div class="hero-cv">
            <a href="{{ $user->resumeUrl() }}" class="btn btn-general btn-white"><i class="fa fa-download" aria-hidden="true"></i> {{ __('site.action.download_resume') }}</a>
        </div>
        @endif

        <a href="#{{ count($education ?? []) ? 'education' : 'contact' }}" class="hero-scroll js-scroll-trigger" aria-label="Scroll down">
            <span class="mouse"><span class="wheel"></span></span>
        </a>

    </div>
</section>

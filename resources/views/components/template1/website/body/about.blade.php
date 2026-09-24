@php
    // Words for the terminal typing line: the roles from Experience, else a default set.
    // Short titles only, so the typing line stays on one line.
    $words = \App\Support\RoleLabel::headlineWords($experience ?? [], $user->role);
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

        <div class="subheading mb-5 hero-terminal">
            <span class="prompt">~$</span>
            <span class="typed" data-words='@json($words)'>{{ $words[0] }}</span><span class="caret"></span>
        </div>

        @if(trim(strip_tags((string) $user->about)) !== '')
        <p class="mb-5" style="max-width: 560px; text-align: justify;">
            {{ strip_tags($user->about) }}
        </p>
        @endif

        <ul class="list-inline list-social-icons mb-0">
            @if($user->email)
            <li class="list-inline-item">
                <a href="mailto:{{$user->email}}" target="_blank">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>
            @endif

            @if($user->phone)
            <li class="list-inline-item">
                <a href="https://wa.me/{{ $user->phone }}?text=Hello%20I%20want%20to%20contact%20you" target="_blank">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-whatsapp fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>
            @endif

            @if($user->linkedIn_url)
            <li class="list-inline-item">
                <a href="{{ $user->linkedIn_url }}" target="_blank">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
            </li>
            @endif
        </ul>

        @if($user->hasResume())
        <div class="hero-cv">
            <a href="{{ $user->resumeUrl() }}" class="btn btn-general btn-white"><i class="fa fa-download" aria-hidden="true"></i> Download CV</a>
        </div>
        @endif

        <a href="#{{ count($education ?? []) ? 'education' : 'contact' }}" class="hero-scroll js-scroll-trigger" aria-label="Scroll down">
            <span class="mouse"><span class="wheel"></span></span>
        </a>

    </div>
</section>

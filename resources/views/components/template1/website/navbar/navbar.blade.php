<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">

    @if($user->image)
    <span class="d-none d-lg-block">
        <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="{{$user->image}}" alt="{{ $user->name }}">
    </span>
    <span class="d-lg-none brand-name">{{ $user->name }}</span>
    @else
    @php
        $initials = collect(preg_split('/\s+/', trim((string) $user->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    @endphp
    <span class="img-profile profile-initials d-none d-lg-flex mx-auto mb-2">{{ $initials }}</span>
    <span class="d-lg-none brand-name">{{ $user->name }}</span>
    @endif
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('site.more.toggle_nav') }}">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#about">{{ __('site.section.about') }}</a>
            </li>

            @if(count($education)!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#education">{{ __('site.section.education') }}</a>
            </li>
            @endif

            @if(count($experience)!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#experience">{{ __('site.section.experience') }}</a>
            </li>
            @endif

            @if(count($project)!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#project">{{ __('site.section.projects') }}</a>
            </li>
            @endif

            @if(count($skill ?? [])!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#skills">{{ __('site.section.skills') }}</a>
            </li>
            @endif

            @if(count($service ?? [])!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#services">{{ __('site.section.services') }}</a>
            </li>
            @endif

            @if(count($testimonial ?? [])!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#reviews">{{ __('site.more.reviews') }}</a>
            </li>
            @endif

            @if(count($blog)!=0)
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#blog">{{ __('site.section.blog') }}</a>
            </li>
             @endif

            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#contact">{{ __('site.section.contact') }}</a>
            </li>
        </ul>
    </div>
</nav>

@props(['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null])

@php
    $asset = fn ($path) => asset('assets/website/template2/'.$path);
    $version = @filemtime(public_path('assets/website/template2/css/custom.css'));
    $links = $sections ?: [
        'about' => 'About',
        'experience' => 'Experience',
        'education' => 'Education',
        'projects' => 'Projects',
        'blog' => 'Blog',
        'contact' => 'Contact',
    ];
    $first = trim(explode(' ', trim((string) $user->name))[0] ?? '');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-website.seo :user="$user" :post="$post" />
    <link rel="icon" href="{{ asset('assets/admin/img/kaiadmin/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ $asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/animated-text/animated-text.css') }}">
    <link rel="stylesheet" href="{{ $asset('css/style.css') }}">
    {{-- Colours from Theme Setting (same --brand-* tokens as the back office and Template 1). --}}
    <style>
        :root {
            {!! \App\Support\Branding::cssDeclarations(\App\Support\Branding::websiteCssVariables($user, 'template2')) !!}
        }
    </style>
    <link rel="stylesheet" href="{{ $asset('css/custom.css') }}?v={{ $version }}">
</head>

<body class="t2">

<nav class="navbar navbar-expand-lg main-nav" id="navbar">
    <div class="container">
        <a class="navbar-brand t2-brand" href="{{ $home ?: '#top' }}">{{ $first ?: $user->name }}<span>.</span></a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#t2-nav" aria-controls="t2-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-align-justify"></span>
        </button>

        <div class="collapse navbar-collapse" id="t2-nav">
            <ul class="navbar-nav ml-auto">
                @foreach($links as $anchor => $label)
                <li class="nav-item"><a class="nav-link" href="{{ $home }}#{{ $anchor }}">{{ $label }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<main id="top">
    {{ $slot }}
</main>

<footer class="t2-footer">
    <div class="container">
        <div class="row t2-footer-main">
            {{-- About --}}
            <div class="col-lg-4 col-md-12 mb-5 mb-lg-0">
                <a class="t2-footer-brand" href="{{ $home ?: '#top' }}">{{ $first ?: $user->name }}<span>.</span></a>
                @if($user->role)
                <p class="t2-footer-role">{{ $user->role }}</p>
                @endif
                <p class="t2-footer-about">{{ \Illuminate\Support\Str::limit(trim(strip_tags((string) $user->about)), 150) }}</p>
                <ul class="list-inline t2-social mb-0">
                    @if($user->linkedIn_url)
                    <li class="list-inline-item"><a href="{{ $user->linkedIn_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="ti-linkedin"></i></a></li>
                    @endif
                    @if($user->email)
                    <li class="list-inline-item"><a href="mailto:{{ $user->email }}" aria-label="Email"><i class="ti-email"></i></a></li>
                    @endif
                    @if($user->phone)
                    <li class="list-inline-item"><a href="https://wa.me/{{ $user->phone }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="ti-mobile"></i></a></li>
                    @endif
                </ul>
            </div>

            {{-- Quick links --}}
            <div class="col-lg-2 col-md-4 col-6 mb-5 mb-lg-0">
                <h5 class="t2-footer-title">Explore</h5>
                <ul class="list-unstyled t2-footer-links">
                    @foreach($links as $anchor => $label)
                    <li><a href="{{ $home }}#{{ $anchor }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Latest posts --}}
            <div class="col-lg-3 col-md-4 col-6 mb-5 mb-lg-0">
                <h5 class="t2-footer-title">Latest Posts</h5>
                @if(count($blog))
                <ul class="list-unstyled t2-footer-posts">
                    @foreach(collect($blog)->take(3) as $item)
                    <li>
                        <a href="{{ route('front.post', [$item->id, request()->id]) }}">{{ $item->title }}</a>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="t2-footer-about">New posts are on the way.</p>
                @endif
            </div>

            {{-- Contact --}}
            <div class="col-lg-3 col-md-4">
                <h5 class="t2-footer-title">Get in Touch</h5>
                <ul class="list-unstyled t2-footer-contact">
                    @if($user->address)
                    <li><i class="ti-location-pin"></i><span>{{ $user->address }}</span></li>
                    @endif
                    @if($user->email)
                    <li><i class="ti-email"></i><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                    @endif
                    @if($user->phone)
                    <li><i class="ti-mobile"></i><a href="https://wa.me/{{ $user->phone }}" target="_blank" rel="noopener">+{{ $user->phone }}</a></li>
                    @endif
                </ul>
                <a href="{{ $home }}#contact" class="btn btn-main btn-sm mt-2">Let's work together</a>
            </div>
        </div>

        <div class="t2-footer-bottom">
            <p class="mb-0">&copy; {{ date('Y') }} <span>{{ $user->name }}</span>. All rights reserved.</p>
            <a href="#top" class="t2-to-top" aria-label="Back to top">Back to top <i class="ti-arrow-up"></i></a>
        </div>
    </div>
</footer>

<script src="{{ $asset('plugins/jQuery/jquery.min.js') }}"></script>
<script src="{{ $asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ $asset('plugins/aos/aos.js') }}"></script>
<script src="{{ $asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ $asset('plugins/animated-text/animated-text.js') }}"></script>
<script src="{{ $asset('js/template2.js') }}?v={{ @filemtime(public_path('assets/website/template2/js/template2.js')) }}"></script>
@stack('t2-scripts')
</body>
</html>

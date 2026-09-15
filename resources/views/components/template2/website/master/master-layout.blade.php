@props(['user', 'title' => null, 'home' => ''])

@php
    $asset = fn ($path) => asset('assets/website/template2/'.$path);
    $version = @filemtime(public_path('assets/website/template2/css/custom.css'));
    $links = [
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
    <title>{{ $title ? $title.' | '.$user->name : $user->name.($user->role ? ' - '.$user->role : '') }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags((string) $user->about), 155) }}">
    <link rel="icon" href="{{ asset('assets/admin/img/kaiadmin/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ $asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/themify/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ $asset('plugins/animated-text/animated-text.css') }}">
    <link rel="stylesheet" href="{{ $asset('css/style.css') }}">
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

<section class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="mb-0">&copy; {{ date('Y') }} <span class="text-white">{{ $user->name }}</span>. All rights reserved.
                    <br><small>Template: <a target="_blank" rel="noopener" href="https://themefisher.com" class="text-white">Thomson by Themefisher</a>, distributed by <a target="_blank" rel="noopener" href="https://themewagon.com" class="text-white">ThemeWagon</a></small>
                </p>
            </div>
            <div class="col-lg-6">
                <div class="widget footer-widget text-lg-right mt-4 mt-lg-0">
                    <ul class="list-inline mb-0">
                        @if($user->linkedIn_url)
                        <li class="list-inline-item"><a href="{{ $user->linkedIn_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="ti-linkedin mr-3"></i></a></li>
                        @endif
                        @if($user->email)
                        <li class="list-inline-item"><a href="mailto:{{ $user->email }}" aria-label="Email"><i class="ti-email mr-3"></i></a></li>
                        @endif
                        @if($user->phone)
                        <li class="list-inline-item"><a href="https://wa.me/{{ $user->phone }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="ti-mobile mr-3"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ $asset('plugins/jQuery/jquery.min.js') }}"></script>
<script src="{{ $asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ $asset('plugins/aos/aos.js') }}"></script>
<script src="{{ $asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ $asset('plugins/animated-text/animated-text.js') }}"></script>
<script src="{{ $asset('js/template2.js') }}?v={{ @filemtime(public_path('assets/website/template2/js/template2.js')) }}"></script>
@stack('t2-scripts')
</body>
</html>

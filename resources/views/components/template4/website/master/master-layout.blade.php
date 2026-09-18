@props(['user', 'home' => '', 'sections' => [], 'post' => null])
@php
    // Colour comes from Theme Setting, saved per template.
    $branding = \App\Support\Branding::websiteColors($user, 'template4');
    $primary = $branding['accent'] ?? '#378c3f';
    $hex = ltrim($primary, '#');
    [$r, $g, $b] = array_map('hexdec', str_split(strlen($hex) === 3 ? preg_replace('/(.)/', '$1$1', $hex) : $hex, 2));
    // Pick readable text for things drawn on the primary colour: dark on a
    // bright accent such as gold, white on a deep one.
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    $onPrimary = $luminance > 0.6 ? '#1b1b1b' : '#ffffff';
    $hover = \App\Support\Branding::darken($primary, 12);
    // Bright accents (gold, mint) are unreadable as text on white; darken
    // them for links and icons, keep them as-is for fills.
    $ink = $luminance > 0.6 ? \App\Support\Branding::darken($primary, 40) : $primary;

    $links = $sections ?: ['about' => 'About', 'experience' => 'Experience', 'education' => 'Education', 'contact' => 'Contact'];
    $brand = trim(explode(' ', trim((string) $user->name))[0] ?? '') ?: $user->name;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<x-website.seo :user="$user" :post="$post" />
<link rel="icon" href="{{ asset('assets/admin/img/kaiadmin/favicon.ico') }}" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200&display=swap" rel="stylesheet">
<link href="{{ asset('assets/website/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/website/template4/css/aos.css') }}" rel="stylesheet">
<link href="{{ asset('assets/website/template4/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/website/template4/css/main.css') }}" rel="stylesheet">
<noscript><style>[data-aos]{opacity:1!important;transform:translate(0) scale(1)!important}</style></noscript>

<style>
:root{
  --t4-primary: {{ $primary }};
  --t4-primary-hover: {{ $hover }};
  --t4-primary-rgb: {{ $r }}, {{ $g }}, {{ $b }};
  --t4-on-primary: {{ $onPrimary }};
  --t4-ink: {{ $ink }};
}

/* Links and accent text on white use the readable shade. */
a, a:hover, a:focus, .text-primary { color: var(--t4-ink); }
.btn-link, .btn-link:hover { color: #555; }
.footer .btn-link:hover { color: var(--t4-ink); }

/* Text drawn on the primary colour follows its brightness. */
.btn-primary, .btn-primary:hover, .btn-primary:focus, .btn-primary:active,
.bg-primary, .bg-primary .h5, .bg-primary p, .badge-primary,
.cc-experience .cc-experience-header, .cc-education .cc-education-header { color: var(--t4-on-primary) !important; }

/* Once the navbar turns solid on scroll it sits on the primary colour. */
.navbar.bg-primary:not(.navbar-transparent) .navbar-brand,
.navbar.bg-primary:not(.navbar-transparent) .nav-link { color: var(--t4-on-primary) !important; }
.navbar.bg-primary:not(.navbar-transparent) .navbar-toggler-bar { background: var(--t4-on-primary); }

.page-header .page-header-image { background-position: center; }
.cc-profile-initials { display: inline-flex; align-items: center; justify-content: center; width: 180px; height: 180px; border-radius: 50%;
  background: var(--t4-primary); color: var(--t4-on-primary); font-size: 56px; font-weight: 700; border: 15px solid transparent; position: relative; z-index: 9999; }
.page-header .btn { width: auto; min-width: 140px; }

/* Hero social links: the template's large grey circles were too heavy. */
.page-header .btn.t4-social { width: 40px; min-width: 40px; height: 40px; padding: 0; margin: 0 5px; font-size: 16px; line-height: 38px;
  background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.45); color: #fff; box-shadow: none; }
.page-header .btn.t4-social i { font-size: 16px; line-height: 38px; }
.page-header .btn.t4-social:hover, .page-header .btn.t4-social:focus { background: var(--t4-primary); border-color: var(--t4-primary); color: var(--t4-on-primary); }
.page-header .button-container .btn-default { margin-right: 0; }
.page-header .category { font-size: 1.1rem; }

.section { padding: 40px 0; }
.page-content > .section:last-child { padding-bottom: 0; }
.title { font-weight: 700; }
.section .h4.title.text-center { margin-top: 0; margin-bottom: 28px; }
.card { border-radius: 6px; }
.section > .container > .card:last-child,
.section > .container > .row:last-child > [class*="col-"] { margin-bottom: 0; }
/* Now UI gives every card body a 190px minimum, which padded short cards
   (a one-line qualification) with empty space. */
.card .card-body { min-height: 0; }

/* Experience / education: the date+place panel. Long company names were
   wrapping over five lines at the template's heading size. */
.cc-experience .cc-experience-header, .cc-education .cc-education-header {
  padding: 28px 18px; height: 100%; display: flex; flex-direction: column; justify-content: center; }
.cc-experience-header p, .cc-education-header p { margin-bottom: .5rem; font-size: .8rem; letter-spacing: .5px; }
.cc-experience-header .h5, .cc-education-header .h5 { font-size: 1.05rem; line-height: 1.35; margin: 0; font-weight: 700; }
.cc-experience .card-body .h5, .cc-education .card-body .h5 { font-weight: 700; }
.t4-detail .card-body { padding: 24px 28px; }

/* Phones and small tablets: the panel sits on top, so keep it short. */
@media (max-width: 767px) {
  .section { padding: 30px 0; }
  .cc-experience .cc-experience-header, .cc-education .cc-education-header { padding: 16px 18px; }
  .t4-detail .card-body { padding: 18px 20px; }
  .page-header .content-center { width: 100%; padding: 0 16px; }
  .page-header .btn { min-width: 0; padding-left: 18px; padding-right: 18px; }
  .t4-info .row > [class*="col-"] { flex: 0 0 100%; max-width: 100%; }
}

/* About / basic information */
.t4-info .row + .row { margin-top: 1rem; }
.t4-info strong { font-size: .8rem; letter-spacing: .5px; }
.t4-about p:last-child { margin-bottom: 0; }

/* Services, shown where the old site had skill bars. */
.t4-service { height: 100%; padding: 28px 24px; text-align: center; transition: transform .25s ease, box-shadow .25s ease; }
.t4-service:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(0,0,0,.12); }
.t4-service .t4-icon { width: 64px; height: 64px; margin: 0 auto 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
  background: rgba(var(--t4-primary-rgb), .18); color: var(--t4-ink); font-size: 26px; }
.t4-service .h5 { font-weight: 700; }
.t4-service p { margin-bottom: 0; color: #666; }

/* Portfolio gallery: blog covers with the template's hover caption. */
.gallery .cc-porfolio-image { margin-bottom: 30px; border-radius: 6px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,.12); }
.gallery .cc-porfolio-image figure { margin: 0; aspect-ratio: 4 / 3; background: #222; }
/* Covers are posters with the headline at the top: keep the top in view. */
.gallery .cc-porfolio-image figure img { width: 100%; height: 100%; object-fit: cover; object-position: top center; }
.gallery figure.cc-effect figcaption { display: flex; flex-direction: column; justify-content: center; padding: 24px; }
.gallery figure.cc-effect .h4 { margin-top: 0; }
.gallery figure.cc-effect p { text-transform: none; letter-spacing: 0; font-size: .95rem; padding: .5em 1em; }
.t4-folio-label { display: block; padding: 14px 18px; background: #fff; color: #333; font-weight: 700; }
.t4-folio-label small { display: block; font-weight: 400; color: #888; }

/* Experience / education bullets */
.t4-bullets { padding-left: 1.1rem; margin: 0; }
.t4-bullets li { margin-bottom: .45rem; }

/* References carousel */
.cc-reference .card { padding: 32px 24px 16px; }
.cc-reference .carousel-item { padding: 10px 0 40px; }
@media (max-width: 767px) { .cc-reference .card { padding: 24px 16px 8px; } .cc-reference .t4-stars { margin-top: 8px; text-align: center; } }
.cc-reference .t4-avatar { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; }
.cc-reference .t4-avatar-initials { width: 110px; height: 110px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
  background: var(--t4-primary); color: var(--t4-on-primary); font-size: 34px; font-weight: 700; }
.t4-stars { color: var(--t4-primary); letter-spacing: 2px; margin-bottom: .75rem; }
.t4-stars .off { color: #d5d5d5; }

/* Contact band: the banner, darkened, behind the form card. */
.cc-contact-information { background: linear-gradient(rgba(20,20,20,.55), rgba(20,20,20,.55)), url('{{ asset('assets/website/template4/img/banner.jpg') }}') center / cover no-repeat; }
.cc-contact .input-group-addon { color: var(--t4-ink); }
.cc-contact .card > .h4.title { padding-top: 28px; margin-top: 0; }
/* Now UI draws textareas borderless and placeholders very faint. */
.cc-contact textarea.form-control { min-height: 130px; max-height: none; border: 1px solid #e3e3e3; padding: 12px 18px; }
.cc-contact .form-control::placeholder { color: #8a8a8a; opacity: 1; }
.cc-contact .form-control { font-size: .9rem; }
.cc-contact .captcha-field label { display: block; margin: 4px 0 8px; font-size: .95rem; }
.cc-contact .captcha-field .form-control { max-width: 220px; }
/* Icon + field read as one pill: round only the outer ends. */
.cc-contact .input-group .input-group-addon { border-radius: 30px 0 0 30px; border-right: 0; }
.cc-contact .input-group .form-control { border-radius: 0 30px 30px 0; border-left: 0; }
.cc-contact .captcha-field .form-control { border-radius: 30px; border: 1px solid #e3e3e3; padding: 10px 18px; }
.cc-contact textarea.form-control { border-radius: 16px; }
@media (max-width: 767px) { .cc-contact .captcha-field .form-control { max-width: 100%; } .cc-contact .btn-primary { width: 100%; } }

/* Blog post page */
.t4-post-body { font-size: 1.05rem; line-height: 1.75; color: #444; }
.t4-post-body img { max-width: 100%; height: auto; border-radius: 6px; }
.t4-post-body h2, .t4-post-body h3, .t4-post-body h4 { margin: 1.6rem 0 .6rem; font-weight: 700; }
.t4-post-body ul, .t4-post-body ol { padding-left: 1.25rem; }
.t4-post-carousel .carousel-item img { width: 100%; max-height: 560px; object-fit: contain; background: #f2f2f2; }
/* Bootstrap's white arrows vanished against the light letterbox. */
.t4-post-carousel .carousel-control-prev-icon, .t4-post-carousel .carousel-control-next-icon {
  width: 40px; height: 40px; border-radius: 50%; background-color: rgba(0,0,0,.5); background-size: 45% 45%; }
.t4-post-carousel .carousel-indicators li { background-color: rgba(0,0,0,.35); }
.t4-post-carousel .carousel-indicators .active { background-color: var(--t4-primary); }

@media (prefers-reduced-motion: reduce) {
  [data-aos] { opacity: 1 !important; transform: none !important; transition: none !important; }
  .cc-profile-image a:before { animation: none !important; }
}
</style>
</head>
<body id="top">
<header>
  <div class="profile-page sidebar-collapse">
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent bg-primary" color-on-scroll="400">
      <div class="container">
        <div class="navbar-translate">
          <a class="navbar-brand" href="{{ $home ?: '#top' }}">{{ $brand }}</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar bar1"></span><span class="navbar-toggler-bar bar2"></span><span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
          <ul class="navbar-nav">
            @foreach($links as $anchor => $label)
            <li class="nav-item"><a class="nav-link smooth-scroll" href="{{ $home }}#{{ $anchor }}">{{ $label }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>

<div class="page-content">
  {{ $slot }}
</div>

<footer class="footer">
  <div class="container text-center">
    @if($user->linkedIn_url)
    <a class="btn btn-link" href="{{ $user->linkedIn_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa fa-linkedin fa-2x" aria-hidden="true"></i></a>
    @endif
    @if($user->email)
    <a class="btn btn-link" href="mailto:{{ $user->email }}" aria-label="Email"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
    @endif
    @if($user->phone)
    <a class="btn btn-link" href="https://wa.me/{{ preg_replace('/\D+/', '', $user->phone) }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i></a>
    @endif
    @if($user->hasResume())
    <a class="btn btn-link" href="{{ $user->resumeUrl() }}" aria-label="Download CV"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
    @endif
  </div>
  <div class="h4 title text-center">{{ $user->name }}</div>
  <div class="text-center text-muted">
    <p>&copy; {{ date('Y') }} {{ $user->name }}. All rights reserved.</p>
  </div>
</footer>

<script src="{{ asset('assets/website/template4/js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/website/template4/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/website/template4/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/website/template4/js/now-ui-kit.js') }}"></script>
<script src="{{ asset('assets/website/template4/js/aos.js') }}"></script>
<script>
$(function () {
  AOS.init({ once: true, disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches });

  // Smooth scroll for in-page links; links to another page just navigate.
  $('a.smooth-scroll').on('click', function (event) {
    if (location.pathname.replace(/^\//, '') !== this.pathname.replace(/^\//, '') || location.hostname !== this.hostname) return;
    var target = $(this.hash);
    if (!target.length) return;
    event.preventDefault();
    $('html, body').animate({ scrollTop: target.offset().top - 60 }, 700);
    $('.navbar-collapse').collapse('hide');
    $('html').removeClass('nav-open');
  });
});
</script>
</body>
</html>

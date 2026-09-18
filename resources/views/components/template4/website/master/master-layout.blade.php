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
    // And the reverse for accent text on the dark bands: lift deep colours.
    $glow = $luminance < 0.5
        ? sprintf('#%02x%02x%02x', (int) round($r + (255 - $r) * .55), (int) round($g + (255 - $g) * .55), (int) round($b + (255 - $b) * .55))
        : $primary;

    $links = $sections ?: ['about' => 'About', 'experience' => 'Experience', 'education' => 'Education', 'contact' => 'Contact'];
    $brand = trim(explode(' ', trim((string) $user->name))[0] ?? '') ?: $user->name;
    $initials = collect(preg_split('/\s+/', trim((string) $user->name)))->filter()->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
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
<script>
  // Motion is opt-in: states that start hidden (typing, drawn underlines,
  // count-up) only apply when scripts run and the visitor allows motion.
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) document.documentElement.classList.add('t4-motion');
</script>

<style>
:root{
  --t4-primary: {{ $primary }};
  --t4-primary-hover: {{ $hover }};
  --t4-primary-rgb: {{ $r }}, {{ $g }}, {{ $b }};
  --t4-on-primary: {{ $onPrimary }};
  --t4-on-primary-rgb: {{ $onPrimary === '#ffffff' ? '255, 255, 255' : '27, 27, 27' }};
  --t4-ink: {{ $ink }};
  --t4-glow: {{ $glow }};
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

/* Skills - the only template that shows the level. */
.t4-skill { margin-bottom: 18px; }
.t4-skill-head { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px; font-size: .92rem; }
.t4-skill-pct { color: #888; font-size: .82rem; }
.t4-skill-track { height: 8px; border-radius: 999px; background: rgba(0,0,0,.08); overflow: hidden; }
.t4-skill-fill { display: block; height: 100%; border-radius: 999px; background: var(--t4-primary, #16a085); }

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

/* ═══════════════ PHONE / TABLET MENU ═══════════════
   Now UI's off-canvas panel, restyled: a sheet in the theme colour (gold for
   Black Gold) over a blurred page. Text uses the colour readable on it. */
.navbar .nav-link .t4-label { transition: color .25s ease, transform .25s ease; }
@media (min-width: 992px) {
  /* Desktop bar: mark the section in view. */
  .navbar .nav-link { position: relative; }
  .navbar .nav-link::after { content: ''; position: absolute; left: 50%; bottom: 2px; width: 0; height: 2px; border-radius: 2px;
    background: currentColor; transform: translateX(-50%); transition: width .3s ease; }
  .navbar .nav-link.active::after, .navbar .nav-link:hover::after { width: 60%; }
}
@keyframes t4-menu-in   { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: none; } }
@keyframes t4-letter-in { from { opacity: 0; transform: translateY(110%) rotate(8deg); } to { opacity: 1; transform: none; } }
@keyframes t4-pill-in   { from { transform: scaleX(0); } to { transform: none; } }

/* The navbar sits above everything, permanently. Raising it only while the
   menu was open got animated by Now UI's "transition: all", so the page
   overlay covered the menu until it caught up. This also keeps the hero
   photo (z-index 9999 in the template) from sliding over the bar. */
.navbar.fixed-top { z-index: 10001; }

/* Menu words: letters are separate spans (for the ripple), clipped by the
   label so they rise out of a slot; a copy rolls up from below on hover. */
.t4-label { display: inline-block; overflow: hidden; vertical-align: bottom; line-height: 1.35; }
.t4-roll { display: inline-block; position: relative; transition: transform .45s cubic-bezier(.2,.7,.2,1); }
.t4-roll::after { content: attr(data-text); position: absolute; left: 0; top: 100%; white-space: nowrap; }
.t4-ch { display: inline-block; }
.nav-link:hover .t4-roll, .nav-link:focus-visible .t4-roll { transform: translateY(-100%); }
@keyframes t4-fade-in   { from { opacity: 0; } to { opacity: 1; } }
@media (max-width: 991px) {
  .sidebar-collapse .navbar-collapse {
    width: min(86vw, 340px) !important; display: flex !important; flex-direction: column; overflow-y: auto;
    padding: 22px 26px 28px; background: var(--t4-primary); color: var(--t4-on-primary);
    box-shadow: -24px 0 60px rgba(0,0,0,.4); transform: translate3d(105%, 0, 0);
    transition: transform .55s cubic-bezier(.7,0,.2,1); }
  /* A light sheen in the corner and faint ruled lines, instead of the gradient into black. */
  .sidebar-collapse .navbar-collapse:before { opacity: 1; filter: none;
    background: radial-gradient(circle at 100% 0%, rgba(255,255,255,.45), transparent 50%),
                radial-gradient(circle at 0% 100%, rgba(255,255,255,.18), transparent 45%),
                radial-gradient(circle at 30% 45%, rgba(255,255,255,.12), transparent 40%); }
  .nav-open .sidebar-collapse .navbar-collapse { transform: none; }
  /* Keep the page and the bar where they are; dim and blur the page instead. */
  .nav-open .sidebar-collapse .navbar-translate, .nav-open .sidebar-collapse .wrapper { transform: none !important; }
  .nav-open .navbar.fixed-top { background: transparent !important; box-shadow: none !important; }
  .nav-open .navbar-brand { opacity: 0; }
  .nav-open .navbar .navbar-toggler-bar { background: var(--t4-on-primary) !important; }
  .navbar-toggler { position: relative; z-index: 2; }
  html.nav-open, html.nav-open body { overflow: hidden; }
  #bodyClick { position: fixed; inset: 0; z-index: 10000; background: rgba(8,8,10,.55); cursor: pointer;
    -webkit-backdrop-filter: blur(5px); backdrop-filter: blur(5px); animation: t4-fade-in .35s ease both; }

  .t4-menu-head { display: flex; align-items: center; gap: 14px; padding: 4px 52px 18px 0; }
  .t4-menu-head img, .t4-menu-initials { width: 54px; height: 54px; flex: 0 0 54px; border-radius: 50%; object-fit: cover;
    border: 2px solid #fff; box-shadow: 0 0 0 4px rgba(255,255,255,.35), 0 8px 20px rgba(0,0,0,.18); }
  .t4-menu-initials { display: flex; align-items: center; justify-content: center; background: var(--t4-on-primary); color: var(--t4-primary); font-weight: 700; }
  .t4-menu-head strong { display: block; color: var(--t4-on-primary); font-size: 1.05rem; line-height: 1.2; }
  .t4-menu-head small { display: block; margin-top: 3px; color: rgba(var(--t4-on-primary-rgb), .7); font-size: .68rem; letter-spacing: 1.5px; text-transform: uppercase; }

  .sidebar-collapse .navbar .navbar-nav { margin-top: 14px; }
  .sidebar-collapse .navbar-collapse .navbar-nav:not(.navbar-logo) .nav-link {
    margin: 0 !important; padding: 14px 4px !important; display: flex; align-items: center;
    font-size: 1.35rem; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--t4-on-primary) !important; }
  /* Current / hovered link: a white pill slides in behind it. */
  .sidebar-collapse .navbar-collapse .navbar-nav:not(.navbar-logo) .nav-link { position: relative; z-index: 0; }
  .sidebar-collapse .navbar-collapse .navbar-nav:not(.navbar-logo) .nav-link::before { content: ''; position: absolute; inset: 6px -12px; z-index: -1;
    border-radius: 12px; background: rgba(255,255,255,.55); transform: scaleX(0); transform-origin: 0 50%; transition: transform .3s cubic-bezier(.2,.7,.2,1); }
  .sidebar-collapse .navbar-collapse .nav-link:hover::before, .sidebar-collapse .navbar-collapse .nav-link:focus::before,
  .sidebar-collapse .navbar-collapse .nav-link.active::before { transform: scaleX(1); }
  /* The page you're on (or just tapped): a solid black pill with gold letters,
     clearly different from the pale hover pill. */
  .sidebar-collapse .navbar-collapse .navbar-nav:not(.navbar-logo) .nav-link.active { color: var(--t4-primary) !important; }
  .sidebar-collapse .navbar-collapse .navbar-nav:not(.navbar-logo) .nav-link.active::before { background: var(--t4-on-primary);
    box-shadow: 0 10px 24px rgba(0,0,0,.22); transform: none; transition: none; animation: t4-pill-in .45s cubic-bezier(.2,.7,.2,1) both; }
  .sidebar-collapse .navbar-collapse .nav-link:active::before { transform: scaleX(1) scale(.97); }
  .sidebar-collapse .navbar-collapse .nav-link:hover .t4-label, .sidebar-collapse .navbar-collapse .nav-link:focus .t4-label,
  .sidebar-collapse .navbar-collapse .nav-link.active .t4-label { transform: translateX(8px); }

  /* Letters ripple up, link after link, each time the menu opens. */
  .t4-motion.nav-open .sidebar-collapse .navbar-collapse .t4-ch { animation: t4-letter-in .55s cubic-bezier(.2,.7,.2,1) both;
    animation-delay: calc(.2s + var(--i) * .07s + var(--c) * .03s); }
  /* The close button lives in .navbar-translate, which Now UI gives a
     translate3d() - its own layer at level 0, under the sheet (1032). Raise
     the whole bar above the sheet, and draw the X a little bolder. */
  .sidebar-collapse .navbar .navbar-translate { z-index: 1040; }
  .nav-open .sidebar-collapse .navbar .navbar-toggler-bar { height: 2px; }

  .t4-menu-foot { margin-top: auto; padding-top: 26px; }
  /* On the gold sheet the CV button flips: dark with gold text. */
  .t4-menu-foot .t4-menu-cv { display: block; width: 100%; margin: 0 0 18px; background: var(--t4-on-primary) !important;
    color: var(--t4-primary) !important; border-color: var(--t4-on-primary) !important; }
  .t4-menu-foot .t4-menu-cv:hover { box-shadow: 0 10px 22px rgba(0,0,0,.25); }
  .t4-menu-social { display: flex; gap: 10px; }
  /* Solid black circles with gold icons, matching the CV button above. */
  .t4-menu-social a { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    background: var(--t4-on-primary); color: var(--t4-primary); border: 0;
    transition: background-color .25s ease, color .25s ease, transform .25s ease; }
  .t4-menu-social a:hover, .t4-menu-social a:focus { background: #fff; color: var(--t4-on-primary); transform: translateY(-2px); }

  /* Everything slides in, one after another, each time the menu opens. */
  .t4-motion.nav-open .t4-menu-head { animation: t4-menu-in .5s .1s cubic-bezier(.2,.7,.2,1) both; }
  .t4-motion.nav-open .t4-menu-foot { animation: t4-menu-in .5s .55s cubic-bezier(.2,.7,.2,1) both; }
}

/* ═══════════════ MOTION ═══════════════ */
@keyframes t4-zoom   { from { transform: scale(1); } to { transform: scale(1.14) translate(-1.5%, -1%); } }
@keyframes t4-rise   { from { opacity: 0; transform: translateY(26px); } to { opacity: 1; transform: none; } }
@keyframes t4-float  { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
@keyframes t4-drift  { 0% { transform: translate(0, 0) scale(1); } 50% { transform: translate(40px, -60px) scale(1.25); } 100% { transform: translate(-30px, 20px) scale(.9); } }
@keyframes t4-blink  { 50% { opacity: 0; } }
@keyframes t4-sheen  { from { left: -70%; } to { left: 130%; } }
@keyframes t4-spin   { to { transform: rotate(360deg); } }

/* Hero background: a slow zoom on its own layer, so the template's parallax
   (which moves .page-header-image) keeps working. */
.page-header .page-header-image { overflow: hidden; }
.t4-hero-bg { position: absolute; inset: -2%; background-size: cover; background-position: center; will-change: transform; }
.t4-motion .t4-hero-bg { animation: t4-zoom 26s ease-in-out infinite alternate; }

/* Soft light orbs drifting over the photo. */
.t4-orbs { position: absolute; inset: 0; z-index: 1; overflow: hidden; pointer-events: none; }
.t4-orbs span { position: absolute; border-radius: 50%; background: radial-gradient(circle, rgba(var(--t4-primary-rgb), .55), transparent 70%); filter: blur(4px); opacity: .55; }
.t4-orbs span:nth-child(1) { width: 180px; height: 180px; top: 12%; left: 8%; }
.t4-orbs span:nth-child(2) { width: 110px; height: 110px; top: 60%; left: 20%; }
.t4-orbs span:nth-child(3) { width: 240px; height: 240px; top: 20%; right: 6%; }
.t4-orbs span:nth-child(4) { width: 90px;  height: 90px;  top: 70%; right: 22%; }
.t4-orbs span:nth-child(5) { width: 130px; height: 130px; top: 5%;  left: 48%; }
.t4-motion .t4-orbs span { animation: t4-drift 18s ease-in-out infinite alternate; }
.t4-motion .t4-orbs span:nth-child(2) { animation-duration: 14s; animation-delay: -4s; }
.t4-motion .t4-orbs span:nth-child(3) { animation-duration: 22s; animation-delay: -9s; }
.t4-motion .t4-orbs span:nth-child(4) { animation-duration: 16s; animation-delay: -2s; }
.t4-motion .t4-orbs span:nth-child(5) { animation-duration: 20s; animation-delay: -12s; }
.page-header .container { position: relative; z-index: 2; }

/* Hero entrance, one element after another. */
.t4-motion .t4-hero-in > * { opacity: 0; animation: t4-rise .8s cubic-bezier(.2,.7,.2,1) forwards; }
.t4-motion .t4-hero-in > :nth-child(1) { animation-delay: .1s; }
.t4-motion .t4-hero-in > :nth-child(2) { animation-delay: .3s; }
.t4-motion .t4-hero-in > :nth-child(3) { animation-delay: .5s; }
.t4-motion .t4-hero-in > :nth-child(4) { animation-delay: .7s; }
.t4-motion .page-header .button-container { opacity: 0; animation: t4-rise .8s .9s cubic-bezier(.2,.7,.2,1) forwards; }
/* Safety net: once the entrance is over, the hero is visible no matter
   what happened to the animation (throttled tab, odd browser). */
.t4-entered .t4-hero-in > *, .t4-entered .page-header .button-container { opacity: 1 !important; animation: none !important; }
/* The photo floats gently once it has arrived. */
.t4-motion .cc-profile-image a { display: inline-block; animation: t4-float 6s ease-in-out 1.2s infinite; }

/* Typed role with a blinking caret. */
.t4-typed { min-height: 1.6em; }
.t4-caret { display: none; width: 2px; height: 1.05em; margin-left: 4px; vertical-align: -2px; background: var(--t4-glow); }
.t4-motion .t4-caret { display: inline-block; animation: t4-blink 1s steps(1) infinite; }

/* Buttons lift and glow. */
.btn-primary { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease; }
.btn-primary:hover, .btn-primary:focus { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(var(--t4-primary-rgb), .45); }

/* Section headings: an underline that draws in when the heading is reached. */
.section .h4.title.text-center::after { content: ''; display: block; width: 56px; height: 3px; margin: 12px auto 0; border-radius: 3px;
  background: var(--t4-primary); transform-origin: center; transition: transform .8s cubic-bezier(.2,.7,.2,1) .15s; }
.t4-motion .section .h4.title.text-center:not(.t4-in)::after { transform: scaleX(0); }

/* Stats band */
.t4-stats { position: relative; padding: 56px 0 40px; color: #fff; overflow: hidden;
  background: linear-gradient(rgba(18,18,18,.82), rgba(18,18,18,.82)), url('{{ asset('assets/website/template4/img/banner.jpg') }}') center 70% / cover no-repeat; }
.t4-stat { text-align: center; margin-bottom: 16px; }
.t4-stat i { font-size: 26px; color: var(--t4-glow); margin-bottom: 10px; display: block; }
.t4-stat-num { display: block; font-size: 2.6rem; font-weight: 700; line-height: 1.1; color: #fff; font-variant-numeric: tabular-nums; }
.t4-stat-label { display: block; margin-top: 4px; font-size: .78rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,.72); }
@media (max-width: 575px) { .t4-stat-num { font-size: 2rem; } .t4-stats { padding: 40px 0 24px; } }

/* Services: the icon turns over and fills on hover. */
.t4-service .t4-icon { transition: transform .6s cubic-bezier(.2,.7,.2,1), background-color .3s ease, color .3s ease; }
.t4-service:hover .t4-icon { transform: rotateY(360deg); background: var(--t4-primary); color: var(--t4-on-primary); }

/* Experience / education cards lift, and a light sweeps across the panel. */
.cc-experience .card, .cc-education .card { transition: transform .3s ease, box-shadow .3s ease; }
.cc-experience .card:hover, .cc-education .card:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(0,0,0,.18); }
.cc-experience .bg-primary, .cc-education .bg-primary { position: relative; overflow: hidden; }
.cc-experience .bg-primary::after, .cc-education .bg-primary::after { content: ''; position: absolute; top: 0; left: -70%; width: 45%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent); transform: skewX(-20deg); pointer-events: none; }
.t4-motion .cc-experience .card:hover .bg-primary::after, .t4-motion .cc-education .card:hover .bg-primary::after { animation: t4-sheen .9s ease; }

/* Portfolio cards lift a little too. */
.gallery .cc-porfolio-image { transition: transform .3s ease, box-shadow .3s ease; }
.gallery .cc-porfolio-image:hover { transform: translateY(-5px); box-shadow: 0 18px 36px rgba(0,0,0,.2); }

/* Reading progress along the top, and a back-to-top button. */
.t4-progress { position: fixed; top: 0; left: 0; z-index: 1100; height: 3px; width: 100%; background: var(--t4-primary);
  transform: scaleX(0); transform-origin: 0 50%; box-shadow: 0 0 10px rgba(var(--t4-primary-rgb), .7); pointer-events: none; }
.t4-top { position: fixed; right: 18px; bottom: 18px; z-index: 1050; width: 44px; height: 44px; border-radius: 50%; border: 0;
  background: var(--t4-primary); color: var(--t4-on-primary); box-shadow: 0 8px 20px rgba(0,0,0,.25); cursor: pointer;
  opacity: 0; visibility: hidden; transform: translateY(12px); transition: opacity .3s ease, transform .3s ease, visibility .3s; }
.t4-top.show { opacity: 1; visibility: visible; transform: none; }
.t4-top:hover { transform: translateY(-3px); }
.t4-top i { font-size: 18px; }

@media (prefers-reduced-motion: reduce) {
  [data-aos] { opacity: 1 !important; transform: none !important; transition: none !important; }
  .cc-profile-image a:before { animation: none !important; }
  .btn-primary:hover, .cc-experience .card:hover, .cc-education .card:hover, .gallery .cc-porfolio-image:hover, .t4-top:hover { transform: none; }
  .t4-service:hover .t4-icon { transform: none; }
  .t4-roll { transition: none; }
  .nav-link:hover .t4-roll, .nav-link:focus-visible .t4-roll { transform: none; }
}
</style>
</head>
<body id="top">
<div class="t4-progress" aria-hidden="true"></div>
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
          {{-- Phone/tablet menu header: who this is. Hidden on the desktop bar. --}}
          <div class="t4-menu-head d-lg-none">
            @if($user->image)
              <img src="{{ $user->image }}" alt="">
            @else
              <span class="t4-menu-initials" aria-hidden="true">{{ $initials }}</span>
            @endif
            <div>
              <strong>{{ $user->name }}</strong>
              @if($user->role)<small>{{ $user->role }}</small>@endif
            </div>
          </div>

          <ul class="navbar-nav">
            @foreach($links as $anchor => $label)
            <li class="nav-item" style="--i: {{ $loop->index }}">
              <a class="nav-link smooth-scroll" href="{{ $home }}#{{ $anchor }}" data-section="{{ $anchor }}" aria-label="{{ $label }}">
                {{-- Letters are split so they can ripple in; a copy rolls up on hover. --}}
                <span class="t4-label" aria-hidden="true"><span class="t4-roll" data-text="{{ $label }}">@foreach(mb_str_split($label) as $char)<span class="t4-ch" style="--c: {{ $loop->index }}">{!! $char === ' ' ? '&nbsp;' : e($char) !!}</span>@endforeach</span></span>
              </a>
            </li>
            @endforeach
          </ul>

          <div class="t4-menu-foot d-lg-none">
            @if($user->hasResume())
            <a class="btn btn-primary btn-round t4-menu-cv" href="{{ $user->resumeUrl() }}"><i class="fa fa-download mr-1" aria-hidden="true"></i> Download CV</a>
            @endif
            <div class="t4-menu-social">
              @if($user->linkedIn_url)<a href="{{ $user->linkedIn_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa fa-linkedin"></i></a>@endif
              @if($user->email)<a href="mailto:{{ $user->email }}" aria-label="Email"><i class="fa fa-envelope"></i></a>@endif
              @if($user->phone)<a href="https://wa.me/{{ preg_replace('/\D+/', '', $user->phone) }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa fa-whatsapp"></i></a>@endif
            </div>
          </div>
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

<button class="t4-top" type="button" aria-label="Back to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>

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
    // The tapped link turns black at once; the scroll spy agrees when we land.
    $('.navbar .nav-link[data-section]').removeClass('active');
    $(this).addClass('active');
    closeMenu();
    $('html, body').animate({ scrollTop: target.offset().top - 60 }, 700);
  });

  // Close through Now UI's own toggle, so its overlay (#bodyClick) goes too;
  // removing only the class left an invisible layer that ate the next tap.
  function closeMenu() {
    if ($('html').hasClass('nav-open')) $('.navbar-toggler').first().trigger('click');
  }
  $(document).on('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });

  // Mark the menu link for the section currently in view.
  var navLinks = document.querySelectorAll('.navbar .nav-link[data-section]');
  if ('IntersectionObserver' in window && navLinks.length) {
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        navLinks.forEach(function (a) { a.classList.toggle('active', a.getAttribute('data-section') === entry.target.id); });
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    navLinks.forEach(function (a) {
      var section = document.getElementById(a.getAttribute('data-section'));
      if (section) spy.observe(section);
    });
  }

  var motion = document.documentElement.classList.contains('t4-motion');
  // The entrance takes 1.7s; after that the hero must be fully shown.
  if (motion) setTimeout(function () { document.documentElement.classList.add('t4-entered'); }, 2500);

  // Reading progress bar and back-to-top button.
  var bar = document.querySelector('.t4-progress');
  var topBtn = document.querySelector('.t4-top');
  function onScroll() {
    var max = document.documentElement.scrollHeight - window.innerHeight;
    var y = window.pageYOffset || document.documentElement.scrollTop;
    if (bar) bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0) + ')';
    if (topBtn) topBtn.classList.toggle('show', y > 600);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
  if (topBtn) topBtn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: motion ? 'smooth' : 'auto' }); });

  // Count a number up from zero, easing out.
  function countUp(el) {
    var target = parseInt(el.getAttribute('data-count'), 10) || 0, start = null;
    function step(ts) {
      if (!start) start = ts;
      var p = Math.min((ts - start) / 1600, 1);
      el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  // Heading underlines draw in and stats count up as they come into view.
  var headings = document.querySelectorAll('.section .h4.title.text-center');
  if ('IntersectionObserver' in window && motion) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        io.unobserve(entry.target);
        if (entry.target.classList.contains('t4-count')) countUp(entry.target);
        else entry.target.classList.add('t4-in');
      });
    }, { threshold: 0.4 });
    headings.forEach(function (el) { io.observe(el); });
    document.querySelectorAll('.t4-count').forEach(function (el) { el.textContent = '0'; io.observe(el); });
  } else {
    headings.forEach(function (el) { el.classList.add('t4-in'); });
  }

  // The hero types through the roles; with motion off it just shows the role.
  var typed = document.querySelector('.t4-typed');
  var text = typed && typed.querySelector('.t4-typed-text');
  var roles = [];
  try { roles = JSON.parse(typed ? typed.getAttribute('data-roles') : '[]') || []; } catch (e) {}
  if (motion && text && roles.length) {
    typed.setAttribute('aria-label', roles.join(', '));
    text.setAttribute('aria-hidden', 'true');
    text.textContent = '';
    var i = 0, pos = 0, deleting = false;
    var tick = function () {
      var word = roles[i];
      if (!deleting) {
        text.textContent = word.slice(0, ++pos);
        if (pos < word.length) return setTimeout(tick, 70);
        if (roles.length < 2) return;            // one role: type it once and stay
        deleting = true;
        return setTimeout(tick, 1800);
      }
      text.textContent = word.slice(0, --pos);
      if (pos > 0) return setTimeout(tick, 35);
      deleting = false;
      i = (i + 1) % roles.length;
      setTimeout(tick, 350);
    };
    setTimeout(tick, 900);                         // after the hero has risen in
  }
});
</script>
</body>
</html>

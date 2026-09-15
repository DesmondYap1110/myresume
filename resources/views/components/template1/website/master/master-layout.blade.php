<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{{ asset('assets/admin/img/kaiadmin/favicon.ico') }}" type="image/x-icon">
    <title>@stack('title')</title>

    <!-- Global stylesheets -->
    @include('components.template1.website.master.master-style')
</head>
<body id="page-top">

    {{-- Boot screen + scroll progress; hidden by assets/website/js/theme.js (CSS fallback after 3s). --}}
    <div class="boot-screen" aria-hidden="true">
        <div class="boot-inner">
            <div class="boot-line"><span class="boot-prompt">&gt;</span> initializing portfolio<span class="boot-dots"></span></div>
            <div class="boot-bar"><span></span></div>
            <div class="boot-meta"><span class="boot-percent">0</span>%</div>
        </div>
    </div>
    <div class="scroll-progress" aria-hidden="true"><span></span></div>

    {{$slot}}

    <!-- Global javascript -->
    @include('components.template1.website.master.master-script')

</body>
</html>

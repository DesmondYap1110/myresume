@props(['user' => null])
{{--
    Colours for this template as --brand-* variables, followed by the website
    theme sheet that reads them. Include after style.css.

    Each template keeps its own colours (Account Setting > Theme Setting);
    without any, it follows the back-office theme.
--}}
@php
    $variables = $user
        ? \App\Support\Branding::websiteCssVariables($user, 'template1')
        : \App\Support\Branding::cssVariables();
@endphp
<style>
    :root {
        {!! \App\Support\Branding::cssDeclarations($variables) !!}
    }
</style>
<link href="{{ asset('assets/website/css/theme.css') }}?v={{ @filemtime(public_path('assets/website/css/theme.css')) }}" rel="stylesheet">

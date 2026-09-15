{{--
    The admin Theme Setting colours as --brand-* variables, followed by the
    website theme sheet that reads them. Include after style.css.
--}}
<style>
    :root {
        {!! \App\Support\Branding::cssDeclarations(\App\Support\Branding::cssVariables()) !!}
    }
</style>
<link href="{{ asset('assets/website/css/theme.css') }}?v={{ @filemtime(public_path('assets/website/css/theme.css')) }}" rel="stylesheet">

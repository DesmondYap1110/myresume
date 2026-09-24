{{--
    Theme colours from config/branding.php + Theme Setting, as --brand-*
    variables, applied over KaiAdmin. Include after the KaiAdmin stylesheet.
    On the login page it also paints the configured background.
--}}
@php
    $variables = \App\Support\Branding::cssVariables();
    $isLogin = request()->routeIs('login.index', 'login.logout');
    $backgroundStyles = $isLogin ? \App\Support\Branding::backgroundStyles() : [];
@endphp

<style>
    :root {
        {!! \App\Support\Branding::cssDeclarations($variables) !!}
    }

    body:not(.login) {
        background: var(--brand-background, #f5f7fd);
    }

    a {
        color: var(--brand-link, #1572e8);
    }

    .btn-primary,
    .btn-primary:disabled,
    .btn-primary:focus {
        background: var(--brand-primary, #212529) !important;
        border-color: var(--brand-primary, #212529) !important;
        color: var(--brand-button-text, #FFD700) !important;
    }

    .btn-primary:hover {
        background: var(--brand-primary-hover, #000) !important;
        border-color: var(--brand-primary-hover, #000) !important;
        color: var(--brand-button-text, #FFD700) !important;
    }

    .sidebar[data-background-color="dark"] {
        background: var(--brand-sidebar, #1a2035) !important;
    }

    .sidebar[data-background-color="dark"] .nav > .nav-item a,
    .sidebar[data-background-color="dark"] .nav > .nav-item a i,
    .sidebar[data-background-color="dark"] .nav > .nav-item a p {
        color: var(--brand-accent, #FFD700) !important;
    }

    .sidebar .nav > .nav-item.active > a:before {
        background: var(--brand-accent, #1d7af3);
    }

    .logo-header[data-background-color="dark"] {
        background: var(--brand-logo-header, #000) !important;
    }

    /*
     * The theme renders .btn-light white on a white card, which leaves every
     * Cancel, Reset and secondary action invisible. Give it a grey that can
     * be seen, without changing any of the markup that uses it.
     */
    .btn-light,
    .btn-light:not(:disabled):not(.disabled) {
        background-color: #eef0f4;
        border: 1px solid #dfe3ea;
        color: #495057;
    }

    .btn-light:hover,
    .btn-light:focus,
    .btn-light:active {
        background-color: #e2e6ed;
        border-color: #cfd5df;
        color: #212529;
    }

    @if ($backgroundStyles)
    body.login {
        {!! \App\Support\Branding::cssDeclarations($backgroundStyles) !!}
    }
    @endif
</style>

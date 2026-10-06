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
     * Room under the content for the fixed copyright strip.
     *
     * It floats over whatever is beneath it, while .page-inner leaves only
     * 24px below the content, so on any page long enough to scroll the last
     * card finished underneath it. The strip is about 52px on a desktop and
     * wraps to two lines on a narrow screen, hence the bigger allowance there.
     */
    .main-panel .page-inner { padding-bottom: 80px; }

    @media (max-width: 575px) {
        .main-panel .page-inner { padding-bottom: 110px; }
    }

    /*
     * Scrollbars in the chosen theme.
     *
     * Only the page's own bar and the boxes that genuinely scroll inside it.
     * scrollbar-color is an inherited property, so declaring it on html hands
     * it to every scrollable descendant - including the sidebar, which draws
     * its own bar with a plugin, and ended up showing two.
     */
    html {
        scrollbar-width: thin;
        scrollbar-color: var(--brand-primary, #212529) rgba(0, 0, 0, .06);
    }

    /* Back to the browser default inside the sidebar, so its plugin is the
       only thing drawing a bar there. */
    .sidebar,
    .sidebar * {
        scrollbar-width: auto;
        scrollbar-color: auto;
    }

    html::-webkit-scrollbar,
    .table-responsive::-webkit-scrollbar,
    .modal-body::-webkit-scrollbar,
    .note-editable::-webkit-scrollbar,
    .dataTables_scrollBody::-webkit-scrollbar { width: 10px; height: 10px; }

    html::-webkit-scrollbar-track,
    .table-responsive::-webkit-scrollbar-track,
    .modal-body::-webkit-scrollbar-track,
    .note-editable::-webkit-scrollbar-track,
    .dataTables_scrollBody::-webkit-scrollbar-track { background: rgba(0, 0, 0, .06); border-radius: 999px; }

    html::-webkit-scrollbar-thumb,
    .table-responsive::-webkit-scrollbar-thumb,
    .modal-body::-webkit-scrollbar-thumb,
    .note-editable::-webkit-scrollbar-thumb,
    .dataTables_scrollBody::-webkit-scrollbar-thumb {
        background: var(--brand-primary, #212529);
        border-radius: 999px;
    }

    html::-webkit-scrollbar-thumb:hover,
    .table-responsive::-webkit-scrollbar-thumb:hover,
    .modal-body::-webkit-scrollbar-thumb:hover,
    .note-editable::-webkit-scrollbar-thumb:hover,
    .dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
        background: var(--brand-primary-hover, var(--brand-primary, #212529));
    }

    /* The sidebar's plugin bar in the theme colour as well, so the two match. */
    .sidebar .scrollbar-inner > .scroll-element .scroll-bar {
        background: var(--brand-primary, #212529) !important;
    }

    /*
     * A note tinted with the live theme rather than a fixed grey, so it
     * belongs to whichever preset is in use. color-mix keeps it a faint wash;
     * the plain values below are the fallback where it is not supported.
     */
    .themed-note {
        display: flex; align-items: flex-start; gap: 8px;
        margin: 0 0 10px; padding: 9px 13px; border-radius: 6px;
        background: #f5f7fd; color: #6c757d; font-size: .82rem; line-height: 1.55;
        border-left: 3px solid var(--brand-primary, #212529);
    }
    .themed-note > i { margin-top: 2px; color: var(--brand-primary, #212529); }
    .themed-note a { color: var(--brand-link, #1572E8); }

    @supports (background: color-mix(in srgb, red 10%, white)) {
        .themed-note {
            background: color-mix(in srgb, var(--brand-accent, #FFD700) 14%, #fff);
            color: color-mix(in srgb, var(--brand-sidebar, #141416) 72%, #fff);
        }
    }

    /* Language switcher in the back-office top bar. */
    .bo-lang { display: flex; gap: 2px; padding: 3px; margin: 0 6px; border-radius: 999px; background: #eef0f4; }
    .bo-lang-item {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 34px; height: 28px; padding: 0 9px; border-radius: 999px;
        font-size: 12px; font-weight: 700; line-height: 1;
        color: #6c757d; text-decoration: none;
    }
    .bo-lang-item:hover { background: #e2e6ed; color: #212529; text-decoration: none; }
    .bo-lang-item.is-active { background: var(--brand-sidebar, #141416); color: var(--brand-accent, #FFD700); }

    /*
     * My Profile's submenu is opened on its own pages. Minimised, the theme
     * hides the item text but keeps the rows, so those open submenus become a
     * tall blank gap between the icons. Hide them while minimised - hovering
     * expands the sidebar again, and then they should show as normal.
     */
    .sidebar_minimize:not(.sidebar_minimize_hover) .sidebar .nav .collapse.show,
    .sidebar_minimize:not(.sidebar_minimize_hover) .sidebar .nav .collapsing {
        display: none !important;
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

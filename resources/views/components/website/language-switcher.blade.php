@php
    $locales = (array) config('locales.supported', []);
    $current = app()->getLocale();
    $meta = $locales[$current] ?? [];
@endphp

@if(count($locales) > 1)
{{--
    One small button rather than a pill per language.

    The full row was about 110px wide and sat on top of each template's menu
    button, which made the menu button look like it had lost its icon. This
    is roughly 40px closed, so it clears the header on every template without
    each one needing its own padding.
--}}
<div class="lang-switch" id="lang-switch">
    <button type="button" class="lang-switch-toggle" aria-haspopup="true" aria-expanded="false"
            aria-label="{{ __('site.label.language') }}" title="{{ $meta['native'] ?? $current }}">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18"/>
        </svg>
        <span>{{ $meta['flag'] ?? strtoupper($current) }}</span>
    </button>

    <ul class="lang-switch-menu" role="menu">
        @foreach($locales as $code => $locale)
        <li role="none">
            {{-- Keeps the rest of the address, so switching on a blog post
                 stays on that post. --}}
            <a role="menuitem" href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}"
               hreflang="{{ $code }}" rel="nofollow"
               @class(['is-active' => $code === $current])>
                <span class="lang-switch-code">{{ $locale['flag'] ?? strtoupper($code) }}</span>
                <span>{{ $locale['native'] ?? $code }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>

<style>
    /* Starting point only - the script below docks this to the left of the
       template's menu button, so the burger keeps the right-hand corner. */
    /* Above template 4's fixed navbar, which sits at 10001 and swallowed every
       tap on this button - the menu looked dead because nothing reached it. */
    .lang-switch { position: fixed; top: 14px; right: 62px; z-index: 10050; }

    /* Template 4's menu is a full-height sheet with its own close button; this
       would otherwise float on top of it. */
    html.nav-open .lang-switch { display: none; }

    .lang-switch-toggle {
        display: inline-flex; align-items: center; gap: 6px;
        height: 30px; padding: 0 10px; border: 0; border-radius: 999px;
        font-size: 12px; font-weight: 700; line-height: 1; letter-spacing: .02em;
        color: #fff; background: rgba(20, 20, 22, .76); backdrop-filter: blur(6px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, .18); cursor: pointer;
        transition: background-color .15s ease;
    }
    .lang-switch-toggle:hover { background: rgba(20, 20, 22, .92); }
    .lang-switch-toggle svg { opacity: .8; flex: 0 0 auto; }

    .lang-switch-menu {
        position: absolute; top: calc(100% + 6px); right: 0;
        min-width: 158px; margin: 0; padding: 5px; list-style: none;
        border-radius: 10px; background: rgba(20, 20, 22, .95); backdrop-filter: blur(6px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .26);
        opacity: 0; visibility: hidden; transform: translateY(-4px);
        /* visibility is left out of the transition on purpose: transitioning it
           keeps the menu unclickable for the whole fade, and it has nothing to
           animate anyway. Opacity and the slide carry the movement. */
        transition: opacity .15s ease, transform .15s ease;
    }
    .lang-switch.is-open .lang-switch-menu { opacity: 1; visibility: visible; transform: translateY(0); }

    .lang-switch-menu a {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 10px; border-radius: 7px;
        font-size: 13px; line-height: 1.2; text-decoration: none;
        color: rgba(255, 255, 255, .8); white-space: nowrap;
    }
    .lang-switch-menu a:hover { background: rgba(255, 255, 255, .12); color: #fff; text-decoration: none; }
    .lang-switch-menu a.is-active { color: var(--brand-accent, #FFD700); }
    .lang-switch-code {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 26px; padding: 2px 5px; border-radius: 5px;
        background: rgba(255, 255, 255, .14); font-size: 11px; font-weight: 700;
    }

    @media (max-width: 575px) {
        .lang-switch { top: 10px; right: 56px; }
        .lang-switch-toggle { height: 28px; padding: 0 9px; }
    }

    @media print { .lang-switch { display: none; } }
</style>

<script>
    (function () {
        var box = document.getElementById('lang-switch');
        if (!box) return;

        var button = box.querySelector('.lang-switch-toggle');

        function close() {
            box.classList.remove('is-open');
            button.setAttribute('aria-expanded', 'false');
        }

        button.addEventListener('click', function (event) {
            event.stopPropagation();
            var open = box.classList.toggle('is-open');
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        // Anywhere else, or Escape, puts it away again.
        document.addEventListener('click', function (event) {
            if (!box.contains(event.target)) close();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') close();
        });

        /*
         * Sit beside the menu button rather than on top of it.
         *
         * Each template builds its header differently - templates 1, 2 and 4
         * use a Bootstrap .navbar-toggler, template 3 an Alpine button - so the
         * spot is measured rather than hard-coded per template.
         *
         * The leftmost button of the header's right-hand group, not the
         * rightmost: template 3 puts a theme toggle beside its burger, and
         * anchoring to the burger alone parked this on top of that toggle.
         */
        function scan(selector, pick) {
            var best = null;
            var middle = document.documentElement.clientWidth / 2;

            Array.prototype.forEach.call(document.querySelectorAll(selector), function (el) {
                if (box.contains(el)) return;

                var rect = el.getBoundingClientRect();

                // No size means hidden at this breakpoint; too far down means
                // it belongs to the page, not the header; left of centre means
                // it is not part of the right-hand group.
                if (!rect.width || !rect.height || rect.top > 160) return;
                if (rect.left < middle) return;
                if (!best || pick(rect, best.getBoundingClientRect())) best = el;
            });

            return best;
        }

        function anchor() {
            var button = scan('header button, nav button, .navbar button, .main-nav button',
                function (a, b) { return a.left < b.left; });

            // Mobile: the burger, and whatever sits beside it.
            if (button) return { el: button, side: 'before' };

            // Desktop: no burger, so the last menu link is the thing to clear.
            // Without this the button floated over the end of the menu.
            var link = scan('header nav a, .navbar-nav a, .main-nav .nav-link',
                function (a, b) { return a.right > b.right; });

            return link ? { el: link, side: 'after' } : null;
        }

        /*
         * Around 1024px the menu runs almost to the edge, leaving no room to
         * sit after it, and the button ended up over the last link. Give the
         * menu's own container just enough extra padding to open a slot.
         */
        var host = null;
        var hostPadding = '';

        function fit(target) {
            if (host) {
                host.style.paddingRight = hostPadding;
                host = null;
            }

            if (!target || target.side !== 'after' || !target.el.closest) return;

            var shortBy = (box.offsetWidth + 28)
                - (document.documentElement.clientWidth - target.el.getBoundingClientRect().right);

            if (shortBy <= 0) return;

            host = target.el.closest('.container, .container-fluid, nav, header');
            if (!host) return;

            hostPadding = host.style.paddingRight;
            host.style.paddingRight =
                ((parseFloat(getComputedStyle(host).paddingRight) || 0) + shortBy) + 'px';
        }

        function place(reflow) {
            var target = anchor();

            if (!target) {
                box.style.top = box.style.right = '';
                return;
            }

            // Only on load and resize: a layout write on every scroll event
            // would be wasteful, and nothing moves sideways as you scroll.
            if (reflow !== false) fit(target);

            var rect = target.el.getBoundingClientRect();
            var centred = rect.top + (rect.height / 2) - (box.offsetHeight / 2);

            // clientWidth, not innerWidth: innerWidth counts the scrollbar,
            // which a fixed element's right offset does not.
            var viewport = document.documentElement.clientWidth;
            var edge = target.side === 'before'
                ? viewport - rect.left + 8                              // tuck in to its left
                : viewport - rect.right - 14 - box.offsetWidth;         // sit out past its right

            // A header that scrolls away would otherwise drag this off screen.
            box.style.top = Math.max(10, centred) + 'px';
            box.style.right = Math.max(10, edge) + 'px';
        }

        place();
        window.addEventListener('load', function () { place(); });
        window.addEventListener('resize', function () { place(); });
        window.addEventListener('scroll', function () { place(false); }, { passive: true });
    })();
</script>
@endif

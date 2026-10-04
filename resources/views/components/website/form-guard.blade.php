{{--
    Hidden anti-bot fields for the public contact form. The honeypot is
    invisible to people (and hidden from screen readers), so anything filled
    in it came from a bot. The timestamp is signed by the server.
--}}
<div aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden">
    <label for="{{ \App\Support\SpamGuard::honeypot }}">{{ __('site.more.honeypot') }}</label>
    <input type="text" id="{{ \App\Support\SpamGuard::honeypot }}" name="{{ \App\Support\SpamGuard::honeypot }}" value="" tabindex="-1" autocomplete="off">
</div>
<input type="hidden" name="{{ \App\Support\SpamGuard::timestamp }}" value="{{ \App\Support\SpamGuard::token() }}">

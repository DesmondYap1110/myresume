@props(['label' => null, 'class' => 'form-control', 'theme' => 'auto'])
{{--
    Anti-spam check for the contact form.

    CAPTCHA_DRIVER=turnstile uses Cloudflare Turnstile; without keys (or with
    CAPTCHA_DRIVER=math) it falls back to a small sum, which needs no account
    and is readable by screen readers.

    The Turnstile script is loaded inline here rather than pushed to a stack,
    because not every template has a script stack.
--}}
@php $driver = \App\Support\Captcha::driver(); @endphp

@if($driver === 'turnstile')
    <div class="cf-turnstile"
         data-sitekey="{{ config('captcha.turnstile.site_key') }}"
         data-theme="{{ $theme }}"></div>
    @once
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endonce
    @error('captcha_answer')
        <span class="captcha-error" role="alert" style="display:block;margin-top:6px;font-size:13px;line-height:1.4;color:#e74c3c">{{ $message }}</span>
    @enderror
@elseif($driver === 'math')
    @php $captcha = \App\Support\Captcha::question(); @endphp
    <label for="{{ \App\Support\Captcha::field }}">{{ $label ?? __('site.ui.quick_check') }}: {{ $captcha['question'] }} <span aria-hidden="true">*</span></label>
    <input type="text" class="{{ $class }}" id="{{ \App\Support\Captcha::field }}" name="{{ \App\Support\Captcha::field }}"
           inputmode="numeric" autocomplete="off" required
           placeholder="{{ __('site.ui.type_number') }}"
           aria-label="{{ $captcha['question'] }}">
    @error(\App\Support\Captcha::field)
        {{-- The question above is a new one, so say so rather than just "wrong". --}}
        <span class="captcha-error" role="alert" style="display:block;margin-top:6px;font-size:13px;line-height:1.4;color:#e74c3c">{{ $message }}</span>
    @enderror
@endif

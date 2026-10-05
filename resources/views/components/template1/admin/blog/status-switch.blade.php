@props(['blog' => null])

{{--
    Whether this post appears on the public site. Sits above the language tabs,
    because it applies to the post as a whole rather than to one language.

    The hidden field before the checkbox matters: an unticked checkbox sends
    nothing at all, so without it "off" would look the same as "field missing"
    and the post could never be switched back off.

    A new post starts switched on, which is how every post behaved before this
    existed.
--}}
@php
    $on = old('status', $blog?->status ?? \App\Models\Blog::status_active) == \App\Models\Blog::status_active;
@endphp

<div class="blog-status">
    <input type="hidden" name="status" value="0">
    <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" role="switch" id="blog-status"
               name="status" value="1" @checked($on)>
        <label class="form-check-label" for="blog-status">{{ __('admin.ui.show_on_website') }}</label>
    </div>
</div>

<style>
    .blog-status { margin-bottom: 4px; }
    .blog-status .form-check { display: flex; align-items: center; gap: 9px; padding-left: 0; }
    .blog-status .form-check-input {
        float: none; margin: 0; flex: 0 0 auto;
        width: 2.4em; height: 1.25em; cursor: pointer;
    }
    .blog-status .form-check-input:checked {
        background-color: var(--brand-primary, #212529);
        border-color: var(--brand-primary, #212529);
    }
    .blog-status .form-check-label {
        cursor: pointer; white-space: nowrap;
        font-size: .87rem; font-weight: 600; color: #1a2035;
    }
</style>

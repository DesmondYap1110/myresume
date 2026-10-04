@props(['model', 'fields'])

{{--
    One tab per language for the fields that differ between languages.

    The default language's tab holds the real inputs - name="role" - so the
    module's own validation and saving are untouched, and it keeps whatever
    "required" the form already asked for. The other tabs post to
    translations[<code>][<field>] and are always optional: an empty box means
    "show the default language here".

    $fields is [name => ['label' => …, 'type' => 'text|textarea|rich',
                         'required' => bool, 'placeholder' => …]]
--}}
@php
    $locales = (array) config('locales.supported', []);
    $default = (string) config('locales.default', 'en');
    $uid = class_basename($model).'-'.($model->getKey() ?: 'new');

    // On an "add" form there is no record yet; the controller stores the
    // other languages straight after it creates one.
@endphp

<div class="lf-block">
    <ul class="nav nav-tabs lf-tabs" role="tablist">
        @foreach($locales as $code => $meta)
        @php
            $done = $code === $default
                ? null
                : collect($model->exists ? $model->translationsFor($code) : [])->filter()->count();
        @endphp
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $code === $default ? 'active' : '' }}" type="button" role="tab"
                    data-bs-toggle="tab" data-bs-target="#lf-{{ $uid }}-{{ $code }}">
                {{ $meta['native'] ?? $code }}
                @if($code === $default)
                    <span class="lf-req">{{ __('admin.ui.lang_required') }}</span>
                @elseif($done)
                    <span class="badge bg-success ms-1">{{ $done }}</span>
                @endif
            </button>
        </li>
        @endforeach
    </ul>

    <div class="tab-content lf-panes">
        @foreach($locales as $code => $meta)
        @php
            $isDefault = $code === $default;
            $saved = (!$isDefault && $model->exists) ? $model->translationsFor($code) : [];
        @endphp
        <div class="tab-pane fade {{ $isDefault ? 'show active' : '' }}"
             id="lf-{{ $uid }}-{{ $code }}" role="tabpanel">

            @unless($isDefault)
            <p class="themed-note">
                <i class="fas fa-info-circle"></i>
                {{ __('admin.ui.lang_optional', ['language' => $locales[$default]['native'] ?? $default]) }}
            </p>
            @endunless

            <div class="row">
            @foreach($fields as $name => $field)
            @php
                $type = $field['type'] ?? 'text';
                $inputName = $isDefault ? $name : "translations[$code][$name]";
                $id = 'lf-'.$uid.'-'.$code.'-'.$name;
                $value = $isDefault
                    ? old($name, $model->{$name})
                    : old("translations.$code.$name", $saved[$name] ?? '');
                $width = $field['width'] ?? ($type === 'text' ? 'col-md-6' : 'col-12');
            @endphp
            <div class="{{ $width }} py-2">
                <label for="{{ $id }}">
                    {{ $field['label'] ?? \Illuminate\Support\Str::headline($name) }}
                    @if($isDefault && ($field['required'] ?? false))<span class="text-danger">*</span>@endif
                </label>

                @if($type === 'text')
                <input type="text" class="form-control" id="{{ $id }}" name="{{ $inputName }}"
                       value="{{ $value }}" maxlength="500"
                       placeholder="{{ $field['placeholder'] ?? ($meta['native'] ?? $code) }}"
                       @if($isDefault && ($field['required'] ?? false)) required @endif>
                @else
                <textarea class="form-control {{ $type === 'rich' ? 'lf-rich' : '' }}"
                          id="{{ $id }}" name="{{ $inputName }}" rows="{{ $field['rows'] ?? 5 }}"
                          placeholder="{{ $field['placeholder'] ?? ($meta['native'] ?? $code) }}"
                          @if($isDefault && ($field['required'] ?? false)) required @endif>{!! $value !!}</textarea>
                @endif

                @error($isDefault ? $name : "translations.$code.$name")
                <span class="text-danger d-block">{{ $message }}</span>
                @enderror
            </div>
            @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

@once
<style>
    .lf-block {
        border: 1px solid #d9dee8; border-radius: 10px; overflow: hidden;
        background: #fff; margin: 10px 0 12px; box-shadow: 0 1px 3px rgba(20, 20, 30, .06);
    }

    /* Dark strip so the language you are editing is unmistakable. */
    .lf-tabs {
        padding: 0 10px; gap: 6px; border: 0;
        background: var(--brand-sidebar, #141416);
    }
    .lf-tabs .nav-link {
        border: 0; border-radius: 0; margin: 0;
        padding: 10px 16px; font-weight: 600; font-size: .87rem;
        color: rgba(255, 255, 255, .62); background: none;
        border-bottom: 3px solid transparent;
    }
    .lf-tabs .nav-link:hover { color: #fff; background: rgba(255, 255, 255, .07); }
    .lf-tabs .nav-link.active {
        color: var(--brand-accent, #FFD700);
        background: rgba(255, 255, 255, .06);
        border-bottom-color: var(--brand-accent, #FFD700);
    }
    .lf-req {
        margin-left: 8px; font-size: .66rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: rgba(255, 255, 255, .45);
    }
    .lf-tabs .nav-link.active .lf-req { color: rgba(255, 255, 255, .62); }

    .lf-panes { padding: 14px 16px 16px; }
    .lf-panes .row { --bs-gutter-x: 16px; }
    .lf-panes .py-2 { padding-top: .35rem !important; padding-bottom: .35rem !important; }
    /* .themed-note lives in branding-styles, shared with the resume note. */
    .lf-panes label { font-size: .82rem; font-weight: 600; color: #495057; margin-bottom: 7px; }
    .lf-panes .form-control { border-color: #d9dee8; }
    .lf-panes .form-control:focus { border-color: var(--brand-primary, #212529); }

    /* Tighter on a phone, where the same spacing reads as a big empty band.
       Tabs scroll sideways rather than wrapping onto a second row. */
    @media (max-width: 767px) {
        .lf-block { margin: 12px 0 14px; border-radius: 10px; }
        .lf-tabs {
            flex-wrap: nowrap; overflow-x: auto; padding: 0 6px;
            gap: 2px; -webkit-overflow-scrolling: touch; scrollbar-width: none;
        }
        .lf-tabs::-webkit-scrollbar { display: none; }
        .lf-tabs .nav-link { padding: 10px 13px; font-size: .84rem; white-space: nowrap; }
        .lf-req { display: none; }
        .lf-panes { padding: 12px 12px 14px; }
        .lf-panes .row { --bs-gutter-x: 12px; }
        .lf-panes .py-2 { padding-top: .4rem !important; padding-bottom: .4rem !important; }
        .themed-note { margin-bottom: 10px; padding: 8px 11px; font-size: .78rem; }
    }
</style>

<script>
    // Summernote is wired to #summernote alone; the other languages get the
    // same editor through a class.
    //
    // An editor built inside a hidden tab measures itself against a container
    // of no width and comes out the wrong height, which is what leaves a tall
    // empty band. So only the visible tab is built now, and the others the
    // first time their tab is opened.
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.jQuery || !jQuery.fn.summernote) return;

        function build(root) {
            jQuery(root).find('.lf-rich').addBack('.lf-rich').each(function () {
                if (this.dataset.lfReady) return;

                this.dataset.lfReady = '1';
                jQuery(this).summernote({
                    tabsize: 2,
                    height: 220,
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                });
            });
        }

        document.querySelectorAll('.lf-panes .tab-pane.active').forEach(build);

        document.querySelectorAll('.lf-tabs [data-bs-toggle="tab"]').forEach(function (tab) {
            tab.addEventListener('shown.bs.tab', function () {
                var pane = document.querySelector(tab.dataset.bsTarget);
                if (pane) build(pane);
            });
        });
    });
</script>
@endonce

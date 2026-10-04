@props(['urls' => []])

@php
    // Always offer one empty box, so there is somewhere to paste.
    $rows = collect(old('media', $urls))->filter()->values()->all();
    $rows[] = '';
    $max = \App\Support\MediaEmbed::max;
@endphp

<label>{{ __('admin.ui.media_links') }}</label>
<div id="media-links" data-max="{{ $max }}">
    @foreach($rows as $url)
    <div class="media-row">
        <input type="url" class="form-control" name="media[]" value="{{ $url }}"
               maxlength="500" placeholder="{{ __('admin.ui.media_links_placeholder') }}">
        <button type="button" class="btn btn-danger media-remove" title="{{ __('admin.ui.remove') }}" aria-label="{{ __('admin.ui.remove_link') }}">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endforeach
</div>

<button type="button" class="btn btn-light btn-sm mt-1" id="media-add">
    <i class="fas fa-plus me-1"></i> {{ __('admin.ui.add_another_link') }}
</button>

<p class="themed-note mt-2 mb-0">
    <i class="fas fa-info-circle"></i>
    <span>{{ __('admin.ui.media_links_note', ['max' => $max]) }}</span>
</p>

@error('media')<span class="text-danger d-block">{{ $message }}</span>@enderror

<style>
    .media-row { display: flex; gap: 8px; margin-bottom: 8px; }
    /* Same corner as the box beside it: the theme rounds .form-control to
       .375rem and buttons to 3px, which read as two different shapes sitting
       side by side. */
    .media-row .media-remove { flex: 0 0 auto; width: 42px; border-radius: .375rem; }

    /* In the chosen theme rather than the stock grey. Outlined, because adding
       a link is a lesser action than saving the post. */
    #media-add.btn {
        border: 1px solid var(--brand-primary, #212529);
        border-radius: .375rem;
        background: transparent;
        color: var(--brand-primary, #212529);
        font-weight: 600;
    }
    #media-add.btn:hover:not(:disabled),
    #media-add.btn:focus:not(:disabled) {
        background: var(--brand-primary, #212529);
        color: var(--brand-button-text, #fff);
    }
    #media-add.btn:disabled { opacity: .45; }
</style>

@push('script')
<script>
    // Add and remove link boxes. The last row is never removed, so there is
    // always one to paste into.
    (function () {
        var list = document.getElementById('media-links');
        var add = document.getElementById('media-add');

        if (!list || !add) return;

        var max = parseInt(list.dataset.max, 10) || 8;

        function rows() {
            return list.querySelectorAll('.media-row');
        }

        function sync() {
            add.disabled = rows().length >= max;
        }

        add.addEventListener('click', function () {
            if (rows().length >= max) return;

            var row = rows()[0].cloneNode(true);
            row.querySelector('input').value = '';
            list.appendChild(row);
            row.querySelector('input').focus();
            sync();
        });

        list.addEventListener('click', function (event) {
            var button = event.target.closest('.media-remove');
            if (!button) return;

            if (rows().length > 1) {
                button.closest('.media-row').remove();
            } else {
                button.closest('.media-row').querySelector('input').value = '';
            }

            sync();
        });

        sync();
    })();
</script>
@endpush

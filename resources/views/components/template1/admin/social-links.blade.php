@props(['user'])

@php
    $data = \App\Support\SocialLinks::forForm($user);
    $rows = $data['networks'];
    $custom = old('social_custom', $data['custom']);
    $maxCustom = \App\Support\SocialLinks::maxCustom;
@endphp

<div class="sl-card">
    <div class="sl-head">
        <span class="sl-col-network">{{ __('admin.ui.network') }}</span>
        <span class="sl-col-link">{{ __('admin.ui.link') }}</span>
        <span class="sl-col-show">{{ __('admin.ui.show_on_website') }}</span>
    </div>

    {{-- Flips every switch that has a link beside it. --}}
    <div class="sl-row sl-row-all">
        <div class="sl-col-network">
            <b>{{ __('admin.ui.show_all') }}</b>
        </div>
        <div class="sl-col-link"></div>
        <div class="sl-col-show">
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="sl-all">
            </div>
        </div>
    </div>

    @foreach($rows as $key => $row)
    <div class="sl-row">
        <label class="sl-col-network mb-0" for="sl-{{ $key }}">
            <x-social-icon :network="$row" :size="18" />
            <span>{{ $row['label'] }}</span>
        </label>

        <div class="sl-col-link">
            <input type="url" class="form-control" id="sl-{{ $key }}"
                   name="social[{{ $key }}][url]" maxlength="300"
                   value="{{ old('social.'.$key.'.url', $row['url']) }}"
                   placeholder="{{ $row['placeholder'] }}">
            @error('social.'.$key.'.url')<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
        </div>

        <div class="sl-col-show">
            <div class="form-check form-switch mb-0">
                <input class="form-check-input sl-toggle" type="checkbox" role="switch"
                       name="social[{{ $key }}][show]" value="1"
                       @checked(old('social.'.$key.'.show', $row['show']))>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Anywhere else the member wants to link to. --}}
    <div id="sl-custom" data-max="{{ $maxCustom }}">
        @foreach($custom as $i => $link)
        <div class="sl-row sl-custom-row">
            <div class="sl-col-network">
                <i class="fas fa-link text-muted"></i>
                <input type="text" class="form-control form-control-sm" maxlength="40"
                       name="social_custom[{{ $i }}][label]"
                       value="{{ $link['label'] ?? '' }}"
                       placeholder="{{ __('admin.ui.link_name') }}">
            </div>
            <div class="sl-col-link">
                <input type="url" class="form-control" maxlength="300"
                       name="social_custom[{{ $i }}][url]"
                       value="{{ $link['url'] ?? '' }}" placeholder="https://">
            </div>
            <div class="sl-col-show">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input sl-toggle" type="checkbox" role="switch"
                           name="social_custom[{{ $i }}][show]" value="1"
                           @checked($link['show'] ?? true)>
                </div>
                <button type="button" class="btn btn-danger btn-sm sl-remove" aria-label="{{ __('admin.action.delete') }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div class="sl-foot">
        <button type="button" class="btn btn-light btn-sm" id="sl-add">
            <i class="fas fa-plus me-1"></i> {{ __('admin.ui.add_link') }}
        </button>
        <small class="form-text text-muted mb-0">{{ __('admin.ui.social_note') }}</small>
    </div>
</div>

<style>
    .sl-card { border: 1px solid #d9dee8; border-radius: 10px; overflow: hidden; background: #fff; }
    .sl-head, .sl-row {
        display: grid; grid-template-columns: minmax(150px, 1fr) minmax(200px, 2fr) 150px;
        gap: 14px; align-items: center; padding: 11px 16px;
    }
    .sl-head {
        background: var(--brand-sidebar, #141416); color: rgba(255, 255, 255, .82);
        font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
    }
    .sl-row { border-top: 1px solid #eef0f4; }
    .sl-row:nth-child(even) { background: #fafbfd; }
    .sl-col-network { display: flex; align-items: center; gap: 10px; font-weight: 600; color: #1a2035; }
    .sl-col-network i { width: 20px; text-align: center; font-size: 17px; }
    .sl-col-show { display: flex; align-items: center; justify-content: flex-end; gap: 8px; }
    .sl-col-show .form-check-input { width: 42px; height: 22px; cursor: pointer; }
    .sl-col-show .form-check-input:checked { background-color: var(--brand-primary, #212529); border-color: var(--brand-primary, #212529); }
    .sl-foot { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; padding: 12px 16px; border-top: 1px solid #eef0f4; background: #fafbfd; }
    /* A square button: the theme's btn padding otherwise stretches it wide
       and flat next to the switch. */
    .sl-remove {
        width: 32px; height: 32px; min-width: 32px; flex: 0 0 32px;
        padding: 0; border-radius: 6px; line-height: 1; font-size: 13px;
        display: inline-flex; align-items: center; justify-content: center;
    }

    @media (max-width: 767px) {
        .sl-head { display: none; }
        .sl-row { grid-template-columns: 1fr; gap: 8px; padding: 12px; }
        .sl-col-show { justify-content: flex-start; }
    }
</style>

@push('script')
<script>
    (function () {
        var card = document.querySelector('.sl-card');
        if (!card) return;

        // "Show all" reflects the rest, and sets them when clicked.
        var all = document.getElementById('sl-all');

        function toggles() {
            return card.querySelectorAll('.sl-toggle');
        }

        function sync() {
            var list = toggles();
            all.checked = list.length > 0 && Array.prototype.every.call(list, function (t) { return t.checked; });
        }

        all.addEventListener('change', function () {
            toggles().forEach(function (t) { t.checked = all.checked; });
        });

        card.addEventListener('change', function (event) {
            if (event.target.classList.contains('sl-toggle')) sync();
        });

        // Links the member adds themselves.
        var list = document.getElementById('sl-custom');
        var add = document.getElementById('sl-add');
        var max = parseInt(list.dataset.max, 10) || 10;

        function rows() {
            return list.querySelectorAll('.sl-custom-row');
        }

        function renumber() {
            rows().forEach(function (row, i) {
                row.querySelectorAll('[name]').forEach(function (field) {
                    field.name = field.name.replace(/social_custom\[\d*\]/, 'social_custom[' + i + ']');
                });
            });
            add.disabled = rows().length >= max;
        }

        add.addEventListener('click', function () {
            if (rows().length >= max) return;

            var i = rows().length;
            var row = document.createElement('div');
            row.className = 'sl-row sl-custom-row';
            row.innerHTML =
                '<div class="sl-col-network"><i class="fas fa-link text-muted"></i>' +
                '<input type="text" class="form-control form-control-sm" maxlength="40" name="social_custom[' + i + '][label]" placeholder="{{ __('admin.ui.link_name') }}"></div>' +
                '<div class="sl-col-link"><input type="url" class="form-control" maxlength="300" name="social_custom[' + i + '][url]" placeholder="https://"></div>' +
                '<div class="sl-col-show"><div class="form-check form-switch mb-0">' +
                '<input class="form-check-input sl-toggle" type="checkbox" role="switch" name="social_custom[' + i + '][show]" value="1" checked>' +
                '</div><button type="button" class="btn btn-danger btn-sm sl-remove"><i class="fas fa-times"></i></button></div>';

            list.appendChild(row);
            row.querySelector('input').focus();
            renumber();
            sync();
        });

        list.addEventListener('click', function (event) {
            var button = event.target.closest('.sl-remove');
            if (!button) return;

            button.closest('.sl-custom-row').remove();
            renumber();
            sync();
        });

        renumber();
        sync();
    })();
</script>
@endpush

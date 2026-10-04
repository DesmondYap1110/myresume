@props(['icons', 'service' => null])
{{-- Shared fields for the Service add and edit forms. --}}

<style>
    .icon-picker { display: grid; grid-template-columns: repeat(auto-fill, minmax(96px, 1fr)); gap: 10px; }
    .icon-pick input { position: absolute; opacity: 0; pointer-events: none; }
    .icon-pick span { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 12px 6px; border: 2px solid #ebedf2; border-radius: 10px; cursor: pointer; font-size: 11px; text-align: center; color: #6c757d; transition: border-color .2s ease, color .2s ease; }
    .icon-pick span i { font-size: 20px; color: #1a2035; }
    .icon-pick input:checked + span { border-color: var(--brand-primary, #212529); color: #1a2035; }
    .icon-pick input:checked + span i { color: var(--brand-primary, #212529); }
    .icon-pick input:focus-visible + span { outline: 2px solid var(--brand-primary, #212529); outline-offset: 2px; }
</style>

<div class="card-action">
    <div class="row">
        <div class="col-12 py-1">
            <x-template1.admin.lang-fields
                :model="$service ?? new \App\Models\Service()"
                :fields="[
                    'title' => ['label' => __('admin.ui.title'), 'type' => 'text', 'required' => true, 'width' => 'col-12', 'placeholder' => __('admin.ui.service_title_hint')],
                    'description' => ['label' => __('admin.ui.description'), 'type' => 'textarea', 'required' => true, 'rows' => 3, 'placeholder' => __('admin.ui.service_desc_hint')],
                ]" />
        </div>

        <div class="col-12 py-2">
            <label>{{ __('admin.ui.icon') }} <span class="required-label">*</span></label>
            <div class="icon-picker">
                @php $current = old('icon', $service->icon ?? array_key_first($icons)); @endphp
                @foreach($icons as $key => $icon)
                <label class="icon-pick mb-0">
                    <input type="radio" name="icon" value="{{ $key }}" @checked($current === $key)>
                    <span><i class="{{ $icon['fa'] }}"></i>{{ $icon['label'] }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="col-md-4 py-1">
            <label for="sort_order">{{ __('admin.ui.display_order') }}</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" max="999"
                   value="{{ old('sort_order', $service->sort_order ?? 0) }}">
            <small class="form-text text-muted">{{ __('admin.ui.lower_shows_first') }}</small>
        </div>
    </div>
</div>

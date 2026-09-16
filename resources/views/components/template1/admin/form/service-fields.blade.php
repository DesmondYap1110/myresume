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
            <label for="title">Title <span class="required-label">*</span></label>
            <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Web Development" required maxlength="255"
                   value="{{ old('title', $service->title ?? '') }}">
        </div>

        <div class="col-12 py-1">
            <label for="description">Description <span class="required-label">*</span></label>
            <textarea class="form-control" id="description" name="description" rows="3" required maxlength="1000"
                      placeholder="What you offer, in a sentence or two.">{{ old('description', $service->description ?? '') }}</textarea>
        </div>

        <div class="col-12 py-2">
            <label>Icon <span class="required-label">*</span></label>
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
            <label for="sort_order">Display order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" max="999"
                   value="{{ old('sort_order', $service->sort_order ?? 0) }}">
            <small class="form-text text-muted">Lower shows first.</small>
        </div>
    </div>
</div>

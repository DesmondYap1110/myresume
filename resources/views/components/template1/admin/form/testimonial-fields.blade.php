@props(['testimonial' => null])
{{-- Shared fields for the Testimonial add and edit forms. --}}

<style>
    .star-rating { display: inline-flex; flex-direction: row-reverse; gap: 4px; }
    .star-rating input { position: absolute; opacity: 0; pointer-events: none; }
    .star-rating label { font-size: 26px; color: #dfe2e8; cursor: pointer; margin: 0; transition: color .15s ease; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: var(--brand-accent, #FFD700); }
    .star-rating input:focus-visible + label { outline: 2px solid var(--brand-primary, #212529); outline-offset: 2px; }
</style>

<div class="card-action">
    <div class="row">
        <div class="col-md-6 py-1">
            <label for="name">Client name <span class="required-label">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Sarah Tan" required maxlength="255"
                   value="{{ old('name', $testimonial->name ?? '') }}">
        </div>

        <div class="col-md-6 py-1">
            <label for="position">Role &amp; company</label>
            <input type="text" class="form-control" id="position" name="position" placeholder="e.g. CTO, Acme Sdn Bhd" maxlength="255"
                   value="{{ old('position', $testimonial->position ?? '') }}">
        </div>

        <div class="col-12 py-1">
            <label for="message">Testimonial <span class="required-label">*</span></label>
            <textarea class="form-control" id="message" name="message" rows="4" required maxlength="1000"
                      placeholder="What the client said about working with you.">{{ old('message', $testimonial->message ?? '') }}</textarea>
        </div>

        <div class="col-md-6 py-2">
            <label class="d-block">Rating <span class="required-label">*</span></label>
            @php $rating = (int) old('rating', $testimonial->rating ?? 5); @endphp
            <div class="star-rating">
                @for($i = 5; $i >= 1; $i--)
                <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" @checked($rating === $i)>
                <label for="rating-{{ $i }}" title="{{ $i }} star{{ $i > 1 ? 's' : '' }}"><i class="fas fa-star"></i></label>
                @endfor
            </div>
        </div>

        <div class="col-md-6 py-2">
            <label for="sort_order">Display order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" max="999"
                   value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
            <small class="form-text text-muted">Lower shows first.</small>
        </div>

        <div class="col-12 py-1">
            <label for="image">Photo</label>
            @if($testimonial && $testimonial->image)
            <div class="d-flex align-items-center gap-3 mb-2">
                <img src="{{ $testimonial->image }}" alt="" class="rounded-circle" style="width:64px;height:64px;object-fit:cover">
                <label class="mb-0"><input type="checkbox" name="remove_image" value="1" class="me-1">Remove photo</label>
            </div>
            @endif
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/webp">
            <small class="form-text text-muted">Optional. JPG, PNG or WebP, up to 4 MB. Initials are shown when there is no photo.</small>
        </div>
    </div>
</div>

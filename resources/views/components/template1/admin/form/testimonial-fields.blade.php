@props(['testimonial' => null])
{{-- Shared fields for the Testimonial add and edit forms. --}}

<style>
    .star-rating-row { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .star-rating { display: inline-flex; flex-direction: row-reverse; gap: 6px; }
    .star-rating input { position: absolute; opacity: 0; pointer-events: none; }
    .star-rating label { font-size: 28px; line-height: 1; cursor: pointer; margin: 0; }
    /* KaiAdmin forces every label grey with !important, so the colour goes on
       the icon inside it instead. */
    .star-rating label i { font-size: 28px; color: #d9dde4; transition: color .15s ease, transform .15s ease; }
    .star-rating input:checked ~ label i { color: var(--brand-accent, #FFD700); filter: drop-shadow(0 1px 1px rgba(0,0,0,.3)); }
    /* While hovering, preview the rating you would pick instead of the saved one. */
    .star-rating:hover input ~ label i { color: #d9dde4; filter: none; }
    .star-rating:hover label:hover i,
    .star-rating:hover label:hover ~ label i { color: var(--brand-accent, #FFD700); filter: drop-shadow(0 1px 1px rgba(0,0,0,.3)); }
    .star-rating label:hover i { transform: scale(1.18); }
    .star-rating input:focus-visible + label i { outline: 2px solid var(--brand-primary, #212529); outline-offset: 3px; border-radius: 4px; }
    .star-rating-value { font-weight: 600; color: #495057; }
    .star-rating-value small { font-weight: 400; color: #8d9498; margin-left: 4px; }
</style>

<div class="card-action">
    <div class="row">
        <div class="col-md-6 py-1">
            <label for="name">{{ __('admin.ui.client_name') }} <span class="required-label">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Sarah Tan" required maxlength="255"
                   value="{{ old('name', $testimonial->name ?? '') }}">
        </div>

        <div class="col-12 py-1">
            {{-- The client's name is the same in every language; what they
                 said, and their role, are not. --}}
            <x-template1.admin.lang-fields
                :model="$testimonial ?? new \App\Models\Testimonial()"
                :fields="[
                    'position' => ['label' => __('admin.ui.role_company'), 'type' => 'text', 'width' => 'col-12', 'placeholder' => __('admin.ui.role_company_hint')],
                    'message' => ['label' => __('admin.ui.testimonial'), 'type' => 'textarea', 'required' => true, 'rows' => 4, 'placeholder' => __('admin.ui.testimonial_hint')],
                ]" />
        </div>

        <div class="col-md-6 py-2">
            <label class="d-block">{{ __('admin.ui.rating') }} <span class="required-label">*</span></label>
            @php $rating = (int) old('rating', $testimonial->rating ?? 5); @endphp
            @php $ratingWords = [1 => 'Poor', 2 => 'Fair', 3 => 'Good', 4 => 'Very good', 5 => 'Excellent']; @endphp
            <div class="star-rating-row">
                <div class="star-rating" role="radiogroup" aria-label="{{ __('admin.ui.rating') }}">
                    @for($i = 5; $i >= 1; $i--)
                    <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" @checked($rating === $i)>
                    <label for="rating-{{ $i }}" title="{{ $i }} star{{ $i > 1 ? 's' : '' }} - {{ $ratingWords[$i] }}"><i class="fas fa-star"></i></label>
                    @endfor
                </div>
                <span class="star-rating-value" id="rating-value" aria-live="polite">{{ $rating }} / 5<small>{{ $ratingWords[$rating] ?? '' }}</small></span>
            </div>
            <script>
                // Keep the "4 / 5 Very good" readout in step with the stars.
                (function () {
                    var words = @json($ratingWords), out = document.getElementById('rating-value');
                    document.querySelectorAll('.star-rating input').forEach(function (input) {
                        input.addEventListener('change', function () {
                            out.innerHTML = '';
                            out.appendChild(document.createTextNode(input.value + ' / 5'));
                            var small = document.createElement('small');
                            small.textContent = words[input.value] || '';
                            out.appendChild(small);
                        });
                    });
                })();
            </script>
        </div>

        <div class="col-md-6 py-2">
            <label for="sort_order">{{ __('admin.ui.display_order') }}</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" max="999"
                   value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
            <small class="form-text text-muted">{{ __('admin.ui.lower_shows_first') }}</small>
        </div>

        <div class="col-12 py-1">
            <label for="image">{{ __('admin.ui.photo') }}</label>
            @if($testimonial && $testimonial->image)
            <div class="d-flex align-items-center gap-3 mb-2">
                <img src="{{ $testimonial->image }}" alt="" class="rounded-circle" style="width:64px;height:64px;object-fit:cover">
                <label class="mb-0"><input type="checkbox" name="remove_image" value="1" class="me-1">{{ __('admin.ui.remove_photo') }}</label>
            </div>
            @endif
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/webp">
            <small class="form-text text-muted">Optional. JPG, PNG or WebP, up to 4 MB. Initials are shown when there is no photo.</small>
        </div>
    </div>
</div>

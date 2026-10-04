{{--
    The pictures for one language, inside that language's tab.

    Rendered by x-template1.admin.lang-fields for every pane, so $locale and
    $isDefault come from there, and every tab is laid out the same way:
    title, description, pictures.

    The default language carries the post's real pictures - the ones the
    module validates and orders - so that pane also gets the gallery with the
    cover badge and the reorder arrows. The other languages are optional:
    leave one empty and it shows the default language's pictures.
--}}
@php
    $blog = $blog ?? null;
    $defaultName = (string) (config('locales.supported.'.config('locales.default').'.native') ?: config('locales.default'));
    $existing = ($blog && !$isDefault) ? $blog->imagesOf($locale) : collect();
    $maxImages = \App\Http\Controllers\admin\Blog\BlogController::maxImages;
@endphp

<div class="lf-images">
    <label for="{{ $isDefault ? 'imageInput' : 'lf-images-'.$locale }}">
        {{ __('admin.ui.images') }}
        @if($isDefault)<span class="text-danger">*</span>@endif
    </label>

    @if($isDefault)
        {{-- The pictures already on the post: drag the order, pick the cover,
             or tick one to drop it. --}}
        @if($blog)
        <ul class="gallery-list" id="gallery-list">
            @foreach($blog->images as $image)
            <li class="gallery-row">
                <input type="hidden" name="image_order[]" value="{{ $image->id }}">
                <a href="{{ $image->url }}" target="_blank" rel="noopener"><img src="{{ $image->url }}" alt=""></a>
                <div class="meta">
                    <span class="cover-badge" hidden>{{ __('admin.ui.cover') }}</span>
                    <span class="name">{{ basename($image->path) }}</span>
                </div>
                <div class="actions">
                    <button type="button" class="btn btn-sm btn-light move-up" title="{{ __('admin.ui.move_up') }}" aria-label="{{ __('admin.ui.move_up') }}"><i class="fas fa-arrow-up"></i></button>
                    <button type="button" class="btn btn-sm btn-light move-down" title="{{ __('admin.ui.move_down') }}" aria-label="{{ __('admin.ui.move_down') }}"><i class="fas fa-arrow-down"></i></button>
                    <label class="btn btn-sm btn-outline-danger mb-0 ms-1">
                        <input type="checkbox" class="remove-toggle me-1" name="remove_images[]" value="{{ $image->id }}"> {{ __('admin.ui.remove') }}
                    </label>
                </div>
            </li>
            @endforeach
        </ul>
        @endif

        <input type="file" class="filepond" name="images[]" id="imageInput" multiple accept="{{ \App\Support\SafeMediaUpload::accept() }}">

        <p class="themed-note mt-2 mb-0">
            <i class="fas fa-info-circle"></i>
            <span>
                @if($blog)
                    {{ __('admin.ui.first_media_cover') }}
                    {{ __('admin.ui.media_hint_more', ['max' => $maxImages]) }}
                @else
                    {{ __('admin.ui.media_hint', ['max' => $maxImages]) }}
                @endif
            </span>
        </p>

        @error('images')<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
    @else
        @if($existing->count())
        <ul class="gallery-list mb-2">
            @foreach($existing as $image)
            <li class="gallery-row">
                @if($image->is_video)
                <video class="gallery-thumb" src="{{ $image->url }}" muted playsinline></video>
                @else
                <img class="gallery-thumb" src="{{ $image->url }}" alt="">
                @endif

                <div class="meta"><span class="name">{{ basename($image->path) }}</span></div>

                <div class="actions">
                    <label class="btn btn-sm btn-outline-danger mb-0">
                        <input type="checkbox" class="me-1" name="remove_images[]" value="{{ $image->id }}">
                        {{ __('admin.ui.remove') }}
                    </label>
                </div>
            </li>
            @endforeach
        </ul>
        @endif

        <input type="file" class="filepond lf-pond" id="lf-images-{{ $locale }}" name="images_{{ $locale }}[]" multiple
               accept="{{ \App\Support\SafeMediaUpload::accept() }}">

        <p class="themed-note mt-2 mb-0">
            <i class="fas fa-info-circle"></i>
            <span>{{ __('admin.ui.locale_images_note', ['language' => $defaultName]) }}</span>
        </p>

        @error('images_'.$locale)<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
    @endif
</div>

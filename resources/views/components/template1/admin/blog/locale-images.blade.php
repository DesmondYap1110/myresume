@props(['blog' => null])

{{--
    Pictures for the languages other than the default one.

    A language only needs these when its screenshots genuinely differ - a
    Chinese screen, say. Leave a language empty and it shows the pictures
    above, so nothing has to be uploaded twice.
--}}
@php
    $locales = (array) config('locales.supported', []);
    $default = (string) config('locales.default');
    $others = array_diff_key($locales, [$default => true]);
@endphp

@if($others)
<div class="li-block">
    <ul class="nav nav-tabs li-tabs" role="tablist">
        @foreach($others as $code => $meta)
        @php $count = $blog ? $blog->imagesOf($code)->count() : 0; @endphp
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" type="button" role="tab"
                    data-bs-toggle="tab" data-bs-target="#li-{{ $code }}">
                {{ $meta['native'] ?? $code }}
                @if($count)<span class="badge bg-success ms-1">{{ $count }}</span>@endif
            </button>
        </li>
        @endforeach
    </ul>

    <div class="tab-content li-panes">
        @foreach($others as $code => $meta)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="li-{{ $code }}" role="tabpanel">

            <p class="themed-note">
                <i class="fas fa-info-circle"></i>
                <span>{{ __('admin.ui.locale_images_note', ['language' => $locales[$default]['native'] ?? $default]) }}</span>
            </p>

            @if($blog && $blog->imagesOf($code)->count())
            <ul class="gallery-list mb-2">
                @foreach($blog->imagesOf($code) as $image)
                <li class="gallery-row">
                    @if($image->is_video)
                    <video class="gallery-thumb" src="{{ $image->url }}" muted playsinline></video>
                    @else
                    <img class="gallery-thumb" src="{{ $image->url }}" alt="">
                    @endif

                    <span class="gallery-name">{{ basename($image->path) }}</span>

                    <label class="gallery-remove mb-0">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                        {{ __('admin.ui.remove') }}
                    </label>
                </li>
                @endforeach
            </ul>
            @endif

            <input type="file" class="form-control" name="images_{{ $code }}[]" multiple
                   accept="{{ \App\Support\SafeMediaUpload::accept() }}">

            @error('images_'.$code)<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
        </div>
        @endforeach
    </div>
</div>

<style>
    .li-block { border: 1px solid #d9dee8; border-radius: 10px; overflow: hidden; background: #fff; margin-top: 12px; }
    .li-tabs { padding: 0 10px; gap: 6px; border: 0; background: var(--brand-sidebar, #141416); }
    .li-tabs .nav-link { border: 0; border-radius: 0; padding: 10px 16px; font-weight: 600; font-size: .87rem;
        color: rgba(255, 255, 255, .62); background: none; border-bottom: 3px solid transparent; }
    .li-tabs .nav-link:hover { color: #fff; background: rgba(255, 255, 255, .07); }
    .li-tabs .nav-link.active { color: var(--brand-accent, #FFD700); background: rgba(255, 255, 255, .06);
        border-bottom-color: var(--brand-accent, #FFD700); }
    .li-panes { padding: 14px 16px 16px; }
    .li-panes .gallery-thumb { width: 56px; height: 56px; object-fit: cover; border-radius: 6px; flex: 0 0 auto; }

    @media (max-width: 767px) {
        .li-tabs { flex-wrap: nowrap; overflow-x: auto; scrollbar-width: none; }
        .li-tabs::-webkit-scrollbar { display: none; }
        .li-tabs .nav-link { white-space: nowrap; padding: 10px 13px; }
        .li-panes { padding: 12px; }
    }
</style>
@endif

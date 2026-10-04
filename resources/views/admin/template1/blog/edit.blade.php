@push('script')
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: true,
    allowReorder: true,
    acceptedFileTypes: ['image/*', 'video/mp4', 'video/webm'],
    instantUpload: false,  // preview only, files are sent with the form
    storeAsFile: true,
    labelIdle: '{{ __('admin.ui.add_more_media') }} <span class="filepond--label-action">{{ __('admin.ui.browse') }}</span>'
});

(function () {
    var list = document.getElementById('gallery-list');
    if (!list) return;

    function refresh() {
        var items = list.querySelectorAll('.gallery-row');
        var visible = 0;
        items.forEach(function (row, i) {
            var removed = row.querySelector('.remove-toggle').checked;
            row.classList.toggle('is-removed', removed);
            row.querySelector('.move-up').disabled = i === 0;
            row.querySelector('.move-down').disabled = i === items.length - 1;
            var badge = row.querySelector('.cover-badge');
            badge.hidden = removed || visible !== 0;
            if (!removed) visible++;
        });
    }

    list.addEventListener('click', function (e) {
        var btn = e.target.closest('button');
        if (!btn) return;
        var row = btn.closest('.gallery-row');
        if (btn.classList.contains('move-up') && row.previousElementSibling) {
            list.insertBefore(row, row.previousElementSibling);
        }
        if (btn.classList.contains('move-down') && row.nextElementSibling) {
            list.insertBefore(row.nextElementSibling, row);
        }
        refresh();
    });

    list.addEventListener('change', refresh);
    refresh();
})();
</script>
@endpush

@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <style>
            .gallery-list { list-style: none; padding: 0; margin: 0 0 12px; }
            .gallery-row { display: flex; align-items: center; gap: 12px; padding: 8px; margin-bottom: 8px; border: 1px solid #ebedf2; border-radius: 8px; background: #fff; transition: opacity .2s ease; }
            .gallery-row img { width: 64px; height: 80px; object-fit: cover; border-radius: 6px; flex: 0 0 auto; }
            .gallery-row .meta { flex: 1; min-width: 0; font-size: 13px; }
            .gallery-row .meta .name { display: block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #6c757d; }
            .gallery-row .actions { display: flex; align-items: center; gap: 4px; }
            .gallery-row.is-removed { opacity: .45; }
            .gallery-row.is-removed img { filter: grayscale(1); }
            .cover-badge { display: inline-block; font-size: 11px; font-weight: 600; padding: 1px 8px; border-radius: 999px; background: var(--brand-primary, #212529); color: var(--brand-button-text, #FFD700); margin-bottom: 4px; }
        </style>

        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">{{ __('admin.ui.edit_blog') }}</div>
                    </div>
                </div>
                <form action="{{route("blog.update",request()->id)}}" method = "post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <x-template1.admin.lang-fields
                                    :model="$blog"
                                    :fields="[
                                        'title' => ['label' => __('admin.ui.title'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                        'description' => ['label' => __('admin.ui.description'), 'type' => 'rich', 'required' => true],
                                    ]" />
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                {{-- Was only on the add form, so links could be
                                     set but never changed afterwards. --}}
                                <x-template1.admin.blog.media-links :urls="$blog->mediaUrls()" />
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                {{-- The cover and reordering notes sit together
                                     in one panel below, after the uploader. --}}
                                <label>{{ __('admin.ui.images') }} <span>*</span></label>

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

                                <input type="file" class="filepond" name="images[]" id="imageInput" multiple accept="{{ \App\Support\SafeMediaUpload::accept() }}">
                                <p class="themed-note mt-2 mb-0">
                                    <i class="fas fa-info-circle"></i>
                                    <span>
                                        {{ __('admin.ui.first_media_cover') }}
                                        {{ __('admin.ui.media_hint_more', ['max' => \App\Http\Controllers\admin\Blog\BlogController::maxImages]) }}
                                    </span>
                                </p>

                                <x-template1.admin.blog.locale-images :blog="$blog" />
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button class="btn btn-success">{{ __('admin.ui.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

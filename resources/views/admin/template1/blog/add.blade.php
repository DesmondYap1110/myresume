@push('script')
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: true,
    allowReorder: true,
    maxFiles: {{ \App\Http\Controllers\admin\Blog\BlogController::maxImages }},
    acceptedFileTypes: ['image/*', 'video/mp4', 'video/webm'],
    instantUpload: false,  // preview only, files are sent with the form
    storeAsFile: true,
    labelIdle: '{{ __('admin.ui.drag_drop_media') }} <span class="filepond--label-action">{{ __('admin.ui.browse') }}</span><br><small>{{ __('admin.ui.first_media_cover_short') }}</small>'
});
</script>
@endpush

@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush


<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">{{ __('admin.ui.add_blog') }}</div>
                    </div>
                </div>
                <form action="{{route("blog.create")}}" method = "post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <x-template1.admin.lang-fields
                                    :model="new \App\Models\Blog()"
                                    :fields="[
                                        'title' => ['label' => __('admin.ui.title'), 'type' => 'text', 'required' => true, 'width' => 'col-12', 'placeholder' => __('admin.ui.enter_title')],
                                        'description' => ['label' => __('admin.ui.description'), 'type' => 'rich', 'required' => true],
                                    ]" />
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <x-template1.admin.blog.media-links />
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="imageInput">{{ __('admin.ui.images') }} <span>*</span></label>
                                <input type="file" class="filepond" name="images[]" id="imageInput" multiple accept="{{ \App\Support\SafeMediaUpload::accept() }}">
                                <p class="themed-note mt-2 mb-0">
                                    <i class="fas fa-info-circle"></i>
                                    <span>{{ __('admin.ui.media_hint', ['max' => \App\Http\Controllers\admin\Blog\BlogController::maxImages]) }}</span>
                                </p>
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

@push('script')
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: true,
    allowReorder: true,
    maxFiles: {{ \App\Http\Controllers\admin\Blog\BlogController::maxImages }},
    acceptedFileTypes: ['image/*'],
    instantUpload: false,  // preview only, files are sent with the form
    storeAsFile: true,
    labelIdle: 'Drag &amp; drop images or <span class="filepond--label-action">Browse</span><br><small>The first image is the cover. Drag to reorder.</small>'
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
                        <div class="card-title">Add Blog</div>
                    </div>
                </div>
                <form action="{{route("blog.create")}}" method = "post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="title">Title <span>*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required value="{{old('title')}}">
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="archivement">Description <span>*</span></label>
                                <textarea class="form-control" rows="4" placeholder="Enter Description of Blog" name="description">{{old('description')}}</textarea>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="imageInput">Images <span>*</span></label>
                                <input type="file" class="filepond" name="images[]" id="imageInput" multiple accept="image/jpeg,image/png,image/gif,image/webp">
                                <small class="form-text text-muted">JPG, PNG, GIF or WebP, up to 4 MB each, max {{ \App\Http\Controllers\admin\Blog\BlogController::maxImages }} images.</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

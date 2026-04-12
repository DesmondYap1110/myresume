@push('script')
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: false,
    acceptedFileTypes: ['image/*'],
    instantUpload: false ,  // preview only, no auto upload
    storeAsFile: true
});


$("#imageInput").on("change", function (e) {

    let file = e.target.files[0];
    if (file)
    {
        $("#existing_pond_file").val('');
        let reader = new FileReader();
        reader.onload = function (event) {
            $("#preview")
                .attr("src", event.target.result)
                .show();
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Edit Blog</div>
                    </div>
                </div>
                <form action="{{route("blog.update",request()->id)}}" method = "post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="title">Title <span>*</span></label>
                                <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required value="{{$blog->title}}">
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="archivement">Description <span>*</span></label>
                                <textarea class="form-control" rows="4" placeholder="Enter Description of Blog" name="description">{{$blog->description}}</textarea>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="image">Image<span>*</span></label>
                                <input type="file" class="filepond" name="image" id = "imageInput"  data-image="{{ $blog->image }}">
                                @if($blog->image)
                                <img id="preview" style="width:150px; border-radius:10px;" src="{{ $blog->image }}">
                                @endif

                                <input type="hidden" id="existing_pond_file" name="existing_pond_file" value="{{  $blog->image  }}">
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

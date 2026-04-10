@push('script')
<script>
FilePond.create(document.querySelector('.filepond'), {
    allowMultiple: false,
    acceptedFileTypes: ['image/*'],
    instantUpload: false   // preview only, no auto upload
});


$("#imageInput").on("change", function (e) {

    let file = e.target.files[0];

    if (file) {
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
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="title">Title <span>*</span></label>
                            <input type="text" class="form-control" id="title" placeholder="Enter Title" required>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="archivement">Description <span>*</span></label>
                            <textarea class="form-control" rows="4" placeholder="Enter Description of Blog">4534543</textarea>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="image">Image<span>*</span></label>
                            <input type="file" class="filepond" name="image" id = "imageInput">
                            <img id="preview" style="width:150px; display:none; border-radius:10px;">
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>

</x-template1.admin.master.master-layout>

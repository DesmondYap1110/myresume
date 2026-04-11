<style>
    .img-btn{
        opacity: 0 !important;
    }
    .img-btn:hover{
        opacity: 1 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1a2035 !important;
        margin-bottom: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        color: white;
    }


</style>
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-12">
            <div class="card">
                <div class="card-action">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-12 d-flex justify-content-center align-items-center">
                            <div class="input-file input-file-image ">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img class="img-upload-preview img-circle" width="150" height="150" src="{{asset("assets/admin/img/jm_denis.jpg")}}" alt="preview">
                                    <input type="file" class="d-none" id="uploadImg" name="uploadImg" accept="image/*" required>
                                    <label for="uploadImg" class="btn btn-primary btn-sm  rounded-circle img-btn position-absolute" ><i class="fa fa-upload"></i></label>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                    <label for="name">Name <span>*</span></label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" required>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                    <label for="email">Email Address <span>*</span></label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email" required>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                    <label>Birthday <span>*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="datepicker" name="dob" required>
                                        <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                    <label for="phone">Phone <span>*</span></label>
                                    <input type="text" class="form-control" id="phone" placeholder="Enter Phone" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 py-1">
                            <label for="position">Position Role <span>*</span></label>
                            <input type="text" class="form-control" id="position" placeholder="Enter Position Role" required>
                        </div>
                        <div class="col-md-6 col-lg-4 py-1">
                            <label for="name">Address <span>*</span></label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address" required>
                        </div>
                        <div class="col-md-6 col-lg-4 py-1">
                            <label for="linkedinURL">LinkedIn URL <span>*</span></label>
                            <input type="text" class="form-control" id="linkedinURL" placeholder="Enter linkedIn URL" required>
                        </div>

                    </div>
                </div>
                <div class="card-action">
                    <div class="card-title summertext" data-placeholder = "About Me...">About Me</div>
                    <div id="summernote"></div>
                </div>

                <div class="card-action">
                    <button class="btn btn-success">Edit</button>
                </div>
            </div>
        </div>
</x-template1.admin.master.master-layout>

<script>
    $('.js-example-basic-single').select2({
        placeholder: 'Select Language'
    });
</script>


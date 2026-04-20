
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Add Experience</div>
                    </div>
                </div>
                <form action="{{route('experience.create')}}" method="post">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" name="work_status" id="work_status" >
                                    <label class="mb-0" for="flexCheckChecked">
                                        Currently Working?
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label for="company">Company <span>*</span></label>
                                <input type="text" class="form-control" id="company" placeholder="Enter Company Name" required name="company" value="{{old('company')}}">
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label for="position">Position Role <span>*</span></label>
                                <input type="text" class="form-control" id="position" placeholder="Enter Position Role" required name="role" value="{{old('role')}}">
                            </div>

                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>Start Date <span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker2" name="start_date" required name="start_date" value="{{old('start_date')}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1" id="togglehide">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker3" name="end_date" name="end_date" value="{{old('end_date')}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-title summertext" data-placeholder = "Please Fill In Detail">Detail</div>
                        <textarea name="detail" id="summernote" class="form-control" required>{!! old('detail') !!}</textarea>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

<script>
    $('.datepicker').datetimepicker({
        format: 'MM/YYYY',
    });

$('#work_status').on('change', function () {

    if (this.checked) {
        $('#togglehide').hide();

        // remove required
        $('#togglehide input').prop('required', false);

        // RESET VALUES (important)
        $('#togglehide input').val('');
    }
    else {
        $('#togglehide').show();
        $('#togglehide input').prop('required', true);
    }

}).trigger('change');


</script>

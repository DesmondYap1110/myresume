
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
                                    <input type="text" class="form-control" id="datepicker" name="start_date" required name="start_date" value="{{old('start_date')}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker2" name="end_date" name="end_date" value="{{old('end_date')}}">
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
    $('#datepicker2').datetimepicker({
        format: 'MM/DD/YYYY',
    });

</script>

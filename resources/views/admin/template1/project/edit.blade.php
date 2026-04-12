
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Edit Project</div>
                    </div>
                </div>
                <form action="{{route('project.update',request()->id)}}" method="post" >
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="project_name">Project Name <span>*</span></label>
                                <input type="text" class="form-control" id="project_name" placeholder="Enter Project Name" name="name" value="{{$project_detail->name}}" required>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="company">Company Name <span>*</span></label>
                                <input type="text" class="form-control" id="company" placeholder="Enter Company Name" required  name="company" value="{{$project_detail->company}}" required>
                            </div>

                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>Start Date <span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker" name="start_date" required value="{{$project_detail->start_date}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>End Date<span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="datepicker2" name="end_date" required value="{{$project_detail->end_date}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-title summertext" data-placeholder = "Please Fill In My Past Project Detail">Detail</div>
                         <textarea name="detail" id="summernote" class="form-control" required>{!!$project_detail->detail !!}</textarea>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

<script>
    $('#datepicker2').datetimepicker({
        format: 'MM/DD/YYYY',
    });

    $('#datepicker').datetimepicker('date', moment('{{$project_detail->start_date}}'));
    $('#datepicker2').datetimepicker('date', moment('{{$project_detail->end_date}}'));

</script>

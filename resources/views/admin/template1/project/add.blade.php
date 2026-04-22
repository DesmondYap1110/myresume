@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Add Project</div>
                    </div>
                </div>
                <form action="{{route('project.create')}}" method="post" >
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="project_name">Project Name <span>*</span></label>
                                <input type="text" class="form-control" id="project_name" placeholder="Enter Project Name" name="name" value="{{old('name')}}" required>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <label for="company">Company Name <span>*</span></label>
                                <input type="text" class="form-control" id="company" placeholder="Enter Company Name" required  name="company" value="{{old('company')}}" required>
                            </div>

                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>Start Date <span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker2" name="start_date" required value="{{old('start_date')}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>End Date<span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker3" name="end_date" required value="{{old('end_date')}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-title summertext" data-placeholder = "Please Fill In My Past Project Detail">Detail</div>
                         <textarea name="detail" id="summernote" class="form-control" required>{!! old('detail') !!}</textarea>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

<script>
$('.datepicker').datetimepicker({
    format: 'YYYY-MM',
});

</script>

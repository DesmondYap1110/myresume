@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">{{ __('admin.ui.edit_project') }}</div>
                    </div>
                </div>
                <form action="{{route('project.update',request()->id)}}" method="post" >
                    @csrf
                    <div class="card-action">
                        <div class="row">

                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>{{ __('admin.ui.start_date') }} <span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker2" name="start_date" required value="{{$project_detail->start_date}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>{{ __('admin.ui.end_date') }}<span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker3" name="end_date" required value="{{$project_detail->end_date}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-action">
                        <x-template1.admin.lang-fields
                            :model="$project_detail"
                            :fields="[
                                'name' => ['label' => __('admin.ui.project_name'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                'company' => ['label' => __('admin.ui.company_name'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                'detail' => ['label' => __('admin.ui.detail'), 'type' => 'rich', 'required' => true],
                            ]" />
                    </div>

                    <div class="card-action">
                        <button class="btn btn-dark">{{ __('admin.ui.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

<script>
    $('.datepicker').datetimepicker({
        format: 'YYYY-MM',
    });

    $('#datepicker2').datetimepicker('date', moment('{{$project_detail->start_date}}'));
    $('#datepicker3').datetimepicker('date', moment('{{$project_detail->end_date}}'));

</script>

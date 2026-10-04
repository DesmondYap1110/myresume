
@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">{{ __('admin.ui.edit_experience') }}</div>
                    </div>
                </div>
                <form action="{{route('experience.update',request()->id)}}" method="post">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" name="work_status" id="work_status" @if($experience->work_status) checked @endif>
                                    <label class="mb-0" for="flexCheckChecked">
                                        {{ __('admin.ui.currently_working') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                                <label>{{ __('admin.ui.start_date') }} <span>*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker2" name="start_date" required name="start_date" value="{{$experience->start_date}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-sm-12 py-1" id="togglehide">
                                <label>{{ __('admin.ui.end_date') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" id="datepicker3" name="end_date" name="end_date" value="{{$experience->end_date}}">
                                    <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <x-template1.admin.lang-fields
                            :model="$experience"
                            :fields="[
                                'role' => ['label' => __('admin.ui.position_role'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                'company' => ['label' => __('admin.ui.company_name'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                'detail' => ['label' => __('admin.ui.detail'), 'type' => 'rich', 'required' => true],
                            ]" />
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-dark">{{ __('admin.ui.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>

</x-template1.admin.master.master-layout>

<script>
$('.datepicker').datetimepicker({
    format: 'YYYY-MM',
});

$('#work_status').on('change', function () {

    if (this.checked) {
        $('#togglehide').hide();

        // remove required
        $('#togglehide input').prop('required', false);

        // RESET VALUES (important)
        $('#togglehide input').val('');
    }
    else
    {
        $('#togglehide').show();
        $('#togglehide input').prop('required', true);
    }

}).trigger('change');


</script>

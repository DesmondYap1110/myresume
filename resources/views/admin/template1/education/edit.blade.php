@push('script')

<script>
$(document).ready(function () {
    $('#yearpick').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });
});
</script>
@endpush

@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush


<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">{{ __('admin.ui.edit_education') }}</div>
                </div>
            </div>
            <form action="{{route("education.update",request()->id)}}" method="post">
                @csrf
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <x-template1.admin.lang-fields
                                :model="$education_detail"
                                :fields="[
                                    'institution' => ['label' => __('admin.ui.institution'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                    'certificate' => ['label' => __('admin.ui.certificate'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                    'achievement' => ['label' => __('admin.ui.achievement'), 'type' => 'textarea', 'rows' => 4],
                                ]" />
                        </div>
                        <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                            <label>{{ __('admin.ui.year') }} <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="yearpick" name="year" required value="{{$education_detail->year}}">
                                <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-dark">{{ __('admin.ui.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>



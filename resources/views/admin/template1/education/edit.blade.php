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
                    <div class="card-title">Edit Education</div>
                </div>
            </div>
            <form action="{{route("education.update",request()->id)}}" method="post">
                @csrf
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="institution">Institution <span>*</span></label>
                            <input type="text" class="form-control" id="institution" name="institution" placeholder="Enter Institution" value="{{$education_detail->institution}}" required>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="certificate">Certicate<span>*</span></label>
                            <input type="text" class="form-control" id="certificate" name="certificate" placeholder="Enter Certification" value="{{$education_detail->certificate}}"  required>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                            <label for="archivement">Achievement <span>*</span></label>
                            <textarea class="form-control" rows="4" placeholder="Enter your achievement" name="achievement">{{ $education_detail->achievement }}</textarea>
                        </div>
                        <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                            <label>Year <span>*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="yearpick" name="year" required value="{{$education_detail->year}}">
                                <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-dark">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>



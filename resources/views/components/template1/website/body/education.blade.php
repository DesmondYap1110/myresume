<section class="resume-section p-3 p-lg-5 " id="education">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Education</h2>
        <div class="mb-5 heading-border"></div>
    </div>
    @foreach($education as $data)
    <div class="resume-item col-md-6 col-sm-12 " >
        <div class="card mx-0 p-4 mb-5">
            <div class=" resume-content mr-auto">
                <h4 class="mb-3"><i class="fa fa-graduation-cap mr-3 text-info"></i> {{$data->institution}} </h4>
                <h5> {{$data->certificate}}</h5>

                <p> {{ strip_tags($data->achievement) }}</p>
            </div>
            <div class="resume-date text-md-right">
                <span class="text-primary">{{$data->year}}</span>
            </div>
        </div>
    </div>
    @endforeach

</section>

{{-- {{date("F Y", strtotime($data->start_date))}} - {{ ($data->end_date && $data->end_date != '1970-01-01') ? date("F Y", strtotime($data->end_date)) : 'Now' }} --}}

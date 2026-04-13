<section class="resume-section p-3 p-lg-5 " id="project">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Project</h2>
        <div class="mb-5 heading-border"></div>
    </div>
    @foreach($project as $data)
    <div class="resume-item col-md-6 col-sm-12 " >
        <div class="card mx-0 p-4 mb-5" style="border-color: #17a2b8; box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.21);">
            <div class=" resume-content mr-auto">
                <h4 class="mb-3"><i class="fa fa-briefcase mr-3 text-info"></i> {{$data->company}} </h4>
                <h5> {{$data->name}}</h5>

                <p> {{ strip_tags($data->detail) }}</p>
            </div>
            <div class="resume-date text-md-right">
                <span class="text-primary">{{date("F Y", strtotime($data->start_date))}} - {{ ($data->end_date && $data->end_date != '1970-01-01') ? date("F Y", strtotime($data->end_date)) : 'Now' }}</span>
            </div>
        </div>
    </div>
    @endforeach

</section>

{{-- {{date("F Y", strtotime($data->start_date))}} - {{ ($data->end_date && $data->end_date != '1970-01-01') ? date("F Y", strtotime($data->end_date)) : 'Now' }} --}}

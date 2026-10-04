<section class="resume-section p-3 p-lg-5 d-flex flex-column justify-content-center align-items-center text-center" id="experience">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">{{ __('site.section.experience') }}</h2>
        <div class="mb-5 heading-border"></div>
        </div>
        <div class="main-experience" id="experience-box">
            @foreach($experience as $data)
            <div class="experience">
                <div class="experience-icon"></div>
                <div class="experience-content">
                    <span class="date">{{ \App\Support\Period::label($data->start_date, $data->end_date, false, 'Now') }}</span>
                    <h3>{{$data->t('company')}}</h3>
                    <h5 class="title">{{$data->t('role')}}</h5>
                    <p class="description">
                       {{ strip_tags($data->t('detail')) }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

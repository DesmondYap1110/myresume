<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="services">
    <div class="row my-auto">
        <div class="col-12">
            <h2 class="text-center">Services</h2>
            <div class="mb-5 heading-border"></div>
        </div>
    </div>
    <div class="row my-auto">
        @foreach($service as $item)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card service-card mx-0 p-4 h-100">
                <div class="service-icon"><i class="{{ $item->iconSet()['fa'] }}"></i></div>
                <h4 class="mt-3 mb-2">{{ $item->title }}</h4>
                <p class="mb-0">{{ $item->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

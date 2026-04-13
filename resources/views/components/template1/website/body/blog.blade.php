<section class="resume-section p-3 p-lg-5 d-flex flex-column" id="blog">
    <div class="row my-auto">
        <div class="col-12">
        <h2 class="  text-center">Blog</h2>
        <div class="mb-5 heading-border"></div>
        </div>

    </div>
    <div class="row my-auto">
        @foreach($blog as $data)
        <div class="col-sm-4 blog-item filter finance">
            <a class="blog-link" href="#blog" data-toggle="modal">
                <div class="caption-port">
                    <div class="caption-port-content">
                        <i class="fa fa-search-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="{{$data->image}}" alt="{{$data->image}}">
            </a>
        </div>
        @endforeach

    </div>
</section>

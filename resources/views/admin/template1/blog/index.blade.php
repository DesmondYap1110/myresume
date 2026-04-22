@push('script')
<script>


    // This will create a single gallery from all elements that have class "gallery-item"
    $('.image-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        removalDelay: 300,
        gallery:{
            enabled:true,
        },
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function(openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
</script>
@endpush

@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
     <div class="col-md-12">
        <div class="card">
        <div class="card-header">
            <div class="card-head-row card-tools-still-right">
            <div class="card-title">My Blog</div>
            <div class="card-tools">
                <a href="{{ route('blog.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="Add Blog" ">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        </div>
        <div class="card-body">
            <div class="row">
                @if(count($blog))
                @foreach($blog as $data)
                <div class="col-md-3">
                    <div class="card card-post card-round">
                        <div class=" image-gallery">
                            <a href="{{$data->image}}" class="col-6 col-md-3 mb-4">
                                <img src="{{$data->image}}" class="img-fluid card-img-top" >
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="info-post ms-2">
                                    <p class="date text-muted">{{$data->created_at}}</p>
                                </div>
                            </div>
                            <div class="separator-solid"></div>
                            <h3 class="card-title">{{$data->title}}</h3>
                        </div>
                        <div class="card-header d-flex justify-content-end align-items-center">
                            <button class="btn btn-success btn-sm m-1" onclick="window.location.href='{{ route('blog.edit',$data->id) }}'">Edit</button>
                            <button class="btn btn-danger btn-sm m-1" onclick="window.location.href='{{ route('blog.delete',$data->id) }}'">Delete</button>
                        </div>

                    </div>
                </div>
                @endforeach
                @else
                    <div class="text-center">
                        Empty {{$breadcrumbs['CurrentPage']}}. Add <a href="{{route('blog.add')}}"> {{$breadcrumbs['CurrentPage']}}</a> .
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>


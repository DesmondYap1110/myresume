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
            <div class="card-title">{{ __('admin.ui.my_blog') }}</div>
            <div class="card-tools">
                <a href="{{ route('blog.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="{{ __('admin.ui.add_blog') }}" ">
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
                        <div class="image-gallery position-relative">
                            @foreach($data->images as $image)
                            <a href="{{ $image->url }}" @if(!$loop->first) hidden @endif>
                                <img src="{{ $image->url }}" class="img-fluid card-img-top" alt="{{ $data->title }}">
                            </a>
                            @endforeach
                            @if($data->images->count() > 1)
                            <span class="badge bg-black text-white position-absolute" style="top:10px;right:10px">
                                <i class="fas fa-images me-1"></i>{{ $data->images->count() }}
                            </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="info-post ms-2">
                                    <p class="date text-muted">{{$data->created_at}}</p>
                                </div>
                            </div>
                            <div class="separator-solid"></div>
                            <h3 class="card-title">
                                {{$data->title}}
                                {{-- Hidden posts stay in this list, so say which ones
                                     are not on the site. --}}
                                @if($data->status != \App\Models\Blog::status_active)
                                <span class="badge bg-secondary align-middle">{{ __('admin.ui.hidden') }}</span>
                                @endif
                            </h3>
                        </div>
                        <div class="card-header d-flex justify-content-end align-items-center">
                            <button class="btn btn-success btn-sm m-1" onclick="window.location.href='{{ route('blog.edit',$data->id) }}'">{{ __('admin.ui.edit') }}</button>
                            <a href="{{ route('blog.delete',$data->id) }}" class="btn btn-danger btn-sm m-1"
                               data-confirm="{{ __('admin.confirm.q_delete_post', ['title' => $data->title]) }}"
                               data-confirm-title="{{ __('admin.confirm.t_delete_post') }}" data-confirm-ok="{{ __('admin.confirm.ok_delete') }}">{{ __('admin.ui.delete') }}</a>
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


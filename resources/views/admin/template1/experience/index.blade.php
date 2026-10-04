@php
    $randomColor = ["feed-item-danger","feed-item-success" ,"feed-item-secondary","feed-item-info","feed-item-warning","feed-item-danger"]

@endphp
@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">{{ __('admin.ui.my_experience') }}</div>
                    <div class="card-tools">
                        <a href="{{ route('experience.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="{{ __('admin.ui.add_experience') }}" ">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ol class="activity-feed">
                    @if(count($experience))
                    @foreach($experience as $data)
                    <li class="feed-item">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <time class="date">{{date('F Y', strtotime($data->start_date))}} - {{ $data->end_date? date('F Y', strtotime($data->end_date)) : 'Now' }}</time>
                                <span class="text">{{$data->company}}</span><br>
                                <span class="text"><strong class="text-success">{{$data->role}}</strong></span>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm">
                                    <li><a class="nav-link btn btn-primary text-white"  href="{{ route('experience.edit',$data->id ) }}"><i class="fas fa-edit"></i></a></li>
                                    <li><a class="nav-link btn btn-danger text-white"  href="{{ route('experience.delete',$data->id ) }}"
                                           data-confirm="{{ __('admin.confirm.q_delete_experience', ['role' => $data->role, 'company' => $data->company]) }}"
                                           data-confirm-title="{{ __('admin.confirm.t_delete_experience') }}" data-confirm-ok="{{ __('admin.confirm.ok_delete') }}"><i class="fas fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @else
                        <div class="text-center">
                            Empty {{$breadcrumbs['CurrentPage']}}. Add <a href="{{route('experience.add')}}"> {{$breadcrumbs['CurrentPage']}}</a> .
                        </div>
                    @endif
                </ol>
            </div>
        </div>
    </div>

</x-template1.admin.master.master-layout>

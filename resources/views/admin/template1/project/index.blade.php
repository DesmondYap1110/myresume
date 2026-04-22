@php
    $randomColor = ["feed-item-danger","feed-item-success" ,"feed-item-secondary","feed-item-info","feed-item-warning","feed-item-danger"]

@endphp

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">My Past Project</div>
                    <div class="card-tools">
                        <a href="{{ route('project.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="Add Project" ">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ol class="activity-feed">
                    @if(count($project_detail))
                    @foreach($project_detail as $data)
                    <li class="feed-item">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <time class="date" datetime="9-25">
                                    {{
                                        $data->start_date && $data->end_date    ? (date("F Y", strtotime($data->start_date)) ==
                                        date("F Y", strtotime($data->end_date)) ? date("F Y", strtotime($data->start_date))
                                        : date("F Y", strtotime($data->start_date)) . ' - ' . date("F Y", strtotime($data->end_date)))
                                        : (date("F Y", strtotime($data->start_date ?? $data->end_date)))
                                    }}

                                </time>
                                <span class="text">{{$data->name}}</span></br></br>
                                <span class="text"><strong class="text-danger">{{$data->company}}</strong></span>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm">
                                    <li><a class="nav-link btn btn-primary text-white"  href="{{ route('project.edit',$data->id) }}"><i class="fas fa-edit"></i></a></li>
                                    <li><a class="nav-link btn btn-danger text-white"  href="{{ route('project.delete',$data->id) }}"><i class="fas fa-trash"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @else
                        <div class="text-center">
                            Empty {{$breadcrumbs['CurrentPage']}}. Add <a href="{{route('project.add')}}"> {{$breadcrumbs['CurrentPage']}}</a> .
                        </div>
                    @endif
                </ol>
            </div>
        </div>
    </div>

</x-template1.admin.master.master-layout>



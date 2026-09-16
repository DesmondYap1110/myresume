@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">My Services</div>
                    <div class="card-tools">
                        <a href="{{ route('service.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="Add Service">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-category">Shown in the Services section of your website. Lower order numbers come first.</div>
            </div>
            <div class="card-body">
                @if(count($service))
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width:60px">Order</th>
                                <th style="width:70px">Icon</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th style="width:150px" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service as $data)
                            <tr>
                                <td>{{ $data->sort_order }}</td>
                                <td><i class="{{ $data->iconSet()['fa'] }} fa-lg"></i></td>
                                <td><b>{{ $data->title }}</b></td>
                                <td class="text-muted">{{ Str::limit($data->description, 110) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('service.edit', $data->id) }}" class="btn btn-success btn-sm m-1">Edit</a>
                                    <a href="{{ route('service.delete', $data->id) }}" class="btn btn-danger btn-sm m-1" onclick="return confirm('Delete this service?')">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    Empty {{$breadcrumbs['CurrentPage']}}. Add <a href="{{ route('service.add') }}">{{$breadcrumbs['CurrentPage']}}</a>.
                </div>
                @endif
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>

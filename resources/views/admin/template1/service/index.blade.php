@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">{{ __('admin.ui.my_services') }}</div>
                    <div class="card-tools">
                        <a href="{{ route('service.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="{{ __('admin.ui.add_service') }}">
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
                                <th style="width:60px">{{ __('admin.ui.order') }}</th>
                                <th style="width:70px">{{ __('admin.ui.icon') }}</th>
                                <th>{{ __('admin.ui.title') }}</th>
                                <th>{{ __('admin.ui.description') }}</th>
                                <th style="width:150px" class="text-end">{{ __('admin.ui.action') }}</th>
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
                                    <a href="{{ route('service.edit', $data->id) }}" class="btn btn-success btn-sm m-1">{{ __('admin.ui.edit') }}</a>
                                    <a href="{{ route('service.delete', $data->id) }}" class="btn btn-danger btn-sm m-1" data-confirm="{{ __('admin.confirm.q_delete_service') }}" data-confirm-title="{{ __('admin.confirm.t_delete_service') }}" data-confirm-ok="{{ __('admin.confirm.ok_delete') }}">{{ __('admin.ui.delete') }}</a>
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

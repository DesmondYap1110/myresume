@push('script')
    <script>
    // This will create a single gallery from all elements that have class "gallery-item"
    $(document).ready(function () {
        $('#mytable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
        });
    });

    // The two date boxes only mean anything for "Custom range"; every other
    // period works its own dates out.
    (function () {
        var period = document.getElementById('period');
        if (!period) return;

        var custom = document.querySelectorAll('#inbox-filter .ib-custom');

        function show() {
            custom.forEach(function (el) { el.hidden = period.value !== 'custom'; });
        }

        period.addEventListener('change', show);
        show();
    })();
    </script>
@endpush

@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

<style>
    .ib-filter-bar { padding: 16px 20px; border-top: 1px solid #ebedf2; }
    .ib-filter { display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end; }
    .ib-field { display: flex; flex-direction: column; gap: 6px; min-width: 165px; }
    .ib-field label { margin: 0; font-size: .82rem; font-weight: 600; color: #6c757d; }
    .ib-field .form-control { height: 42px; }
    .ib-actions { display: flex; gap: 10px; }
    .ib-actions .btn { height: 42px; display: inline-flex; align-items: center; font-weight: 600; }
    .ib-range { display: flex; flex-wrap: wrap; gap: 12px; justify-content: space-between;
        padding: 11px 20px; border-top: 1px solid #ebedf2; font-size: .88rem; color: var(--brand-link, #1572E8); }

    @media (max-width: 575px) {
        .ib-field, .ib-actions { width: 100%; }
        .ib-actions .btn { flex: 1; justify-content: center; }
    }
</style>

         <div class="col-md-12">
        <div class="card">
        <div class="card-header">
            <div class="card-head-row card-tools-still-right">
            <div class="card-title">{{ __('admin.menu.inbox') }}</div>
        </div>
        </div>

        <div class="ib-filter-bar">
            <form method="GET" action="{{ route('inbox.view') }}" class="ib-filter" id="inbox-filter">
                <div class="ib-field">
                    <label for="period">{{ __('admin.ui.period') }}</label>
                    <select class="form-control form-select" id="period" name="period">
                        @foreach($filter['periods'] as $key => $label)
                        <option value="{{ $key }}" @selected($filter['period'] === $key)>{{ __('admin.ui.'.$label) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ib-field ib-custom" @unless($filter['period'] === 'custom') hidden @endunless>
                    <label for="from">{{ __('admin.ui.from') }}</label>
                    <input type="date" class="form-control" id="from" name="from"
                           value="{{ $filter['period'] === 'custom' ? $filter['from'] : '' }}" max="{{ now()->format('Y-m-d') }}">
                </div>

                <div class="ib-field ib-custom" @unless($filter['period'] === 'custom') hidden @endunless>
                    <label for="to">{{ __('admin.ui.to') }}</label>
                    <input type="date" class="form-control" id="to" name="to"
                           value="{{ $filter['period'] === 'custom' ? $filter['to'] : '' }}" max="{{ now()->format('Y-m-d') }}">
                </div>

                <div class="ib-field">
                    <label for="read">{{ __('admin.ui.read_status') }}</label>
                    <select class="form-control form-select" id="read" name="read">
                        <option value="any" @selected($filter['read'] === 'any')>{{ __('admin.ui.all_messages') }}</option>
                        <option value="unread" @selected($filter['read'] === 'unread')>{{ __('admin.ui.unread') }}</option>
                        <option value="read" @selected($filter['read'] === 'read')>{{ __('admin.ui.read') }}</option>
                    </select>
                </div>

                <div class="ib-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-filter me-1"></i> {{ __('admin.action.filter') }}
                    </button>
                    <a href="{{ route('inbox.view') }}" class="btn btn-light">
                        <i class="fas fa-redo me-1"></i> {{ __('admin.action.reset') }}
                    </a>
                </div>
            </form>

            @error('from')<span class="text-danger d-block mt-2">{{ $message }}</span>@enderror
            @error('to')<span class="text-danger d-block mt-2">{{ $message }}</span>@enderror
        </div>

        <div class="ib-range">
            <span>{{ $filter['label'] }}</span>
            <span class="text-muted">
                {{ __('admin.ui.messages_count', ['count' => number_format(count($inbox))]) }}
                @if($filter['unread']) · <b>{{ __('admin.ui.unread_count', ['count' => $filter['unread']]) }}</b>@endif
            </span>
        </div>

        <div class="card-body">
            {{-- Without this the table just overflows the card on a phone,
                 with no way to reach the columns on the right. --}}
            <div class="table-responsive">
            <table class="table table-hover" id="mytable">
                <thead>
                    <tr>
                        <th>{{ __('admin.ui.name') }}</th>
                        <th>{{ __('admin.ui.email') }}</th>
                        <th>{{ __('admin.ui.subject') }}</th>
                        <th>{{ __('admin.ui.created_at') }}</th>
                        <th>{{ __('admin.ui.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inbox as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{ \Illuminate\Support\Str::words($data->subject, 4, '...') }}</td>
                        <td>{{$data->created_at}}</td>
                        <td>
                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm d-flex justify-content-center align-items-center">
                                @if(!$data->read_status)
                                <li>
                                    <a class="nav-link btn btn-warning text-white"  href="{{route('inbox.status',$data->id)}}">
                                        <i class="fas fa-envelope fa-lg "></i>
                                    </a>
                                </li>
                                @else
                                <li>
                                    <a class="nav-link btn btn-success text-white"  href="{{route('inbox.status',$data->id)}}">
                                        <i class="fas fa-envelope-open fs-6 "></i>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a class="nav-link btn btn-primary text-white"  href="{{route('inbox.view.message',$data->id)}}">
                                        <i class="fas fa-eye fs-6 "></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link btn btn-danger text-white"  href="{{route('inbox.delete',$data->id)}}"
                                       data-confirm="{{ __('admin.confirm.q_delete_message', ['name' => $data->name]) }}"
                                       data-confirm-title="{{ __('admin.confirm.t_delete_message') }}" data-confirm-ok="{{ __('admin.confirm.ok_delete') }}">
                                        <i class="fas fa-trash fs-6 "></i>
                                    </a>
                                </li>
                            </ul>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>



</x-template1.admin.master.master-layout>

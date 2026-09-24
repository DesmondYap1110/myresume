@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .ai-table td { vertical-align: middle; }
        .ai-who b { display: block; }
        .ai-key { display: inline-block; max-width: 240px; word-break: break-all; white-space: normal;
            font-size: .78rem; line-height: 1.35; color: #495057; background: #f5f7fd; border-radius: 4px; padding: 3px 7px; }
        .ai-model { font-size: .82rem; color: #6c757d; }
        .ai-none { color: #6c757d; font-size: .85rem; }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">AI Setting</div>
                </div>
                <div class="card-category">
                    Who has the AI Assistant set up, and the key each one is using. Members can change their own
                    under Account Setting; edit here when somebody needs a hand.
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover ai-table">
                        <thead>
                            <tr>
                                <th>Person</th>
                                <th>Provider</th>
                                <th>API key</th>
                                <th>Status</th>
                                <th>Last used</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $person)
                            @php
                                $setting = $settings[(string) $person->id] ?? null;
                                $key = $setting ? $setting->plainKey() : null;
                            @endphp
                            <tr>
                                <td class="ai-who">
                                    <b>{{ $person->name }}</b>
                                    <span class="text-muted text-small">{{ $person->email }}</span>
                                    @if($person->isAdmin())<span class="badge bg-dark ms-1">Admin</span>@endif
                                </td>
                                <td>
                                    @if($setting)
                                        {{ $setting->providerLabel() }}
                                        <div class="ai-model">{{ $setting->resolvedModel() }}</div>
                                    @else
                                        <span class="ai-none">Not set up</span>
                                    @endif
                                </td>
                                <td>
                                    @if($key)
                                        <code class="ai-key">{{ $key }}</code>
                                    @elseif($setting && !$setting->needsKey())
                                        <span class="ai-none">No key needed</span>
                                    @else
                                        <span class="ai-none">No key yet</span>
                                    @endif
                                </td>
                                <td>
                                    @if($setting && $setting->isReady())
                                        <span class="badge bg-success">Ready</span>
                                    @elseif($setting && !$setting->enabled)
                                        <span class="badge bg-secondary">Switched off</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Needs a key</span>
                                    @endif
                                </td>
                                <td class="ai-model">
                                    {{ $setting && $setting->last_used_at ? $setting->last_used_at->diffForHumans() : 'Never' }}
                                </td>
                                <td>
                                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm d-flex justify-content-center align-items-center">
                                        <li>
                                            <a class="nav-link btn btn-success text-white" href="{{ route('aisetting.edit', $person->id) }}"
                                               data-toggle="tooltip" title="Set up the AI Assistant for {{ $person->name }}">
                                                <i class="fas fa-pen fs-6"></i>
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
    </div>
</x-template1.admin.master.master-layout>

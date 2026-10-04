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
                    <div class="card-title">{{ __('admin.ui.ai_setting') }}</div>
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
                                <th>{{ __('admin.ui.person') }}</th>
                                <th>{{ __('admin.ui.provider') }}</th>
                                <th>{{ __('admin.ui.api_key') }}</th>
                                <th>{{ __('admin.ui.status') }}</th>
                                <th>{{ __('admin.ui.last_used') }}</th>
                                <th class="text-center">{{ __('admin.ui.action') }}</th>
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
                                    @if($person->isAdmin())<span class="badge bg-dark ms-1">{{ __('admin.ui.admin') }}</span>@endif
                                </td>
                                <td>
                                    @if($setting)
                                        {{ $setting->providerLabel() }}
                                        <div class="ai-model">{{ $setting->resolvedModel() }}</div>
                                    @else
                                        <span class="ai-none">{{ __('admin.ui.not_set_up') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($key)
                                        <code class="ai-key">{{ $key }}</code>
                                    @elseif($setting && !$setting->needsKey())
                                        <span class="ai-none">{{ __('admin.ui.no_key_needed') }}</span>
                                    @else
                                        <span class="ai-none">{{ __('admin.ui.no_key_yet') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($setting && $setting->isReady())
                                        <span class="badge bg-success">{{ __('admin.ui.ready') }}</span>
                                    @elseif($setting && !$setting->enabled)
                                        <span class="badge bg-secondary">{{ __('admin.ui.switched_off') }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ __('admin.ui.needs_a_key') }}</span>
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

@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .member-table td { vertical-align: middle; }
        .member-avatar { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; flex: 0 0 auto; }
        .member-initials { width: 42px; height: 42px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            font-weight: 700; background: var(--brand-primary, #212529); color: var(--brand-button-text, #FFD700); flex: 0 0 auto; }
        .member-who { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .member-link { word-break: break-all; }
        .member-presence { white-space: nowrap; color: #6c757d; font-size: .85rem; }
        .member-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 5px; vertical-align: middle; }
        .member-dot-on { background: #31ce36; box-shadow: 0 0 0 3px rgba(49, 206, 54, .18); }
        .member-dot-off { background: #c9ccd1; }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Member</div>
                    <div class="card-tools">
                        <a href="{{ route('member.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="Add person">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover member-table">
                        <thead>
                            <tr>
                                <th>Person</th>
                                <th>Access</th>
                                <th>Online</th>
                                <th>Website</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $person)
                            <tr>
                                <td>
                                    <div class="member-who">
                                        @if($person->image)
                                            <img src="{{ $person->image }}" alt="" class="member-avatar">
                                        @else
                                            <span class="member-initials" aria-hidden="true">{{ collect(preg_split('/\s+/', trim((string) $person->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('') }}</span>
                                        @endif
                                        <div>
                                            <b>{{ $person->name }}</b>
                                            <div class="text-muted text-small">{{ $person->email }}</div>
                                            @if($person->role)<div class="text-muted text-small">{{ $person->role }}</div>@endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($person->isAdmin())
                                        <span class="badge bg-dark">Admin</span>
                                    @else
                                        <span class="badge bg-light text-dark">Member</span>
                                    @endif
                                    @if($person->id === Auth::id())<span class="badge bg-secondary ms-1">You</span>@endif
                                </td>
                                <td class="member-presence">
                                    @if($person->isOnline())
                                        <span class="member-dot member-dot-on"></span> Online
                                    @else
                                        <span class="member-dot member-dot-off"></span>
                                        {{ $person->last_seen_at ? $person->last_seen_at->diffForHumans() : 'Never signed in' }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('front.show', $person->routeKey()) }}" target="_blank" rel="noopener" class="member-link">/{{ $person->routeKey() }}</a>
                                    <div class="text-muted text-small">{{ config('website_templates.templates.'.$person->websiteTemplate().'.name', $person->websiteTemplate()) }}</div>
                                </td>
                                <td>
                                    @if($person->id === Auth::id())
                                        <span class="btn btn-success btn-sm disabled">Active</span>
                                    @elseif($person->status)
                                        <a href="{{ route('member.status', $person->id) }}" class="btn btn-success btn-sm"
                                           data-confirm="Block {{ $person->name }}? They will not be able to sign in and their website will be hidden."
                                           data-confirm-title="Block member" data-confirm-ok="Block">Active</a>
                                    @else
                                        <a href="{{ route('member.status', $person->id) }}" class="btn btn-danger btn-sm">Blocked</a>
                                    @endif
                                </td>
                                <td>
                                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm d-flex justify-content-center align-items-center">
                                        <li>
                                            <a class="nav-link btn btn-primary text-white" href="{{ route('member.detail', $person->id) }}"
                                               data-toggle="tooltip" title="View everything this member has added">
                                                <i class="fas fa-eye fs-6"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link btn btn-success text-white" href="{{ route('member.edit', $person->id) }}"
                                               data-toggle="tooltip" title="Edit this member">
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

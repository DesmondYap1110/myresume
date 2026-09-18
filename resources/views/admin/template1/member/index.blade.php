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
        .member-counts { white-space: nowrap; color: #6c757d; font-size: .85rem; }
        .member-counts b { color: #495057; }
        .member-link { word-break: break-all; }
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
                <div class="card-category">Everyone with a portfolio on this site. {{ count($members) }} {{ \Illuminate\Support\Str::plural('account', count($members)) }}.</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover member-table">
                        <thead>
                            <tr>
                                <th>Person</th>
                                <th>Website</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $row)
                            @php $person = $row->model; @endphp
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
                                            @if($person->isAdmin())<span class="badge bg-dark ms-1">Admin</span>@endif
                                            @if($person->id === Auth::id())<span class="badge bg-secondary ms-1">You</span>@endif
                                            <div class="text-muted text-small">{{ $person->email }}</div>
                                            @if($person->role)<div class="text-muted text-small">{{ $person->role }}</div>@endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('front.show', $person->routeKey()) }}" target="_blank" rel="noopener" class="member-link">/{{ $person->routeKey() }}</a>
                                    <div class="text-muted text-small">{{ config('website_templates.templates.'.$person->websiteTemplate().'.name', $person->websiteTemplate()) }}</div>
                                </td>
                                <td class="member-counts">
                                    <b>{{ $row->experience }}</b> jobs · <b>{{ $row->education }}</b> education · <b>{{ $row->blog }}</b> posts
                                    <div><b>{{ $row->visits }}</b> visits @if($row->unread) · <span class="text-danger">{{ $row->unread }} unread</span>@endif</div>
                                </td>
                                <td>
                                    @if($person->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Blocked</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('member.edit', $person->id) }}" class="btn btn-success btn-sm">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <small class="form-text text-muted">
                    Blocked accounts cannot sign in and their website returns “not found”. Accounts are never deleted here, so nobody's posts or messages are left behind.
                </small>
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>

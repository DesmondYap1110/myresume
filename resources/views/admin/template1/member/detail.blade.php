@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .member-avatar-lg { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; flex: 0 0 auto; }
        .member-initials-lg { width: 90px; height: 90px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.75rem; font-weight: 700; background: var(--brand-primary, #212529); color: var(--brand-button-text, #FFD700); flex: 0 0 auto; }
        .member-facts dt { font-weight: 600; color: #495057; }
        .member-facts dd { color: #6c757d; margin-bottom: .6rem; word-break: break-word; }
        .member-stat { border-radius: .5rem; background: #f8f9fa; padding: .85rem 1rem; height: 100%; }
        .member-stat b { display: block; font-size: 1.5rem; line-height: 1.1; color: #212529; }
        .member-stat span { color: #6c757d; font-size: .82rem; }
        .member-section td, .member-section th { vertical-align: middle; }
        .member-empty { color: #6c757d; margin: 0; }
    </style>

    {{-- Who they are --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-start" style="gap: 20px;">
                    @if($person->image)
                        <img src="{{ $person->image }}" alt="" class="member-avatar-lg">
                    @else
                        <span class="member-initials-lg" aria-hidden="true">{{ collect(preg_split('/\s+/', trim((string) $person->name)))->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('') }}</span>
                    @endif

                    <div class="flex-grow-1" style="min-width: 260px;">
                        <h4 class="mb-1">
                            {{ $person->name }}
                            @if($person->isAdmin())<span class="badge bg-dark ms-1">{{ __('admin.ui.admin') }}</span>@else<span class="badge bg-light text-dark ms-1">{{ __('admin.ui.member') }}</span>@endif
                            @if($person->id === Auth::id())<span class="badge bg-secondary ms-1">{{ __('admin.ui.you') }}</span>@endif
                            @if($person->status)<span class="badge bg-success ms-1">{{ __('admin.ui.active') }}</span>@else<span class="badge bg-danger ms-1">{{ __('admin.ui.blocked') }}</span>@endif
                            @if($person->isOnline())<span class="badge bg-success ms-1">{{ __('admin.ui.online') }}</span>@endif
                        </h4>
                        @if($person->role)<div class="text-muted">{{ $person->role }}</div>@endif
                        <div class="mt-2">
                            <a href="{{ route('front.show', $person->routeKey()) }}" target="_blank" rel="noopener">{{ rtrim(url('/'), '/') }}/{{ $person->routeKey() }}</a>
                            <span class="text-muted">· {{ config('website_templates.templates.'.$person->websiteTemplate().'.name', $person->websiteTemplate()) }}</span>
                        </div>
                    </div>

                    <div class="ms-auto">
                        <a href="{{ route('member.edit', $person->id) }}" class="btn btn-success btn-sm">{{ __('admin.ui.edit') }}</a>
                        <a href="{{ route('member.view') }}" class="btn btn-dark btn-sm">{{ __('admin.ui.back_to_member') }}</a>
                    </div>
                </div>

                <div class="separator-solid my-3"></div>

                <div class="row member-facts">
                    <div class="col-md-4">
                        <dl class="mb-0">
                            <dt>{{ __('admin.ui.email') }}</dt><dd>{{ $person->email }}</dd>
                            <dt>{{ __('admin.ui.phone') }}</dt><dd>{{ $person->phone ?: '—' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="mb-0">
                            <dt>{{ __('admin.ui.date_of_birth') }}</dt><dd>{{ $person->dob ? date('j F Y', strtotime($person->dob)) : '—' }}</dd>
                            <dt>{{ __('admin.ui.address') }}</dt><dd>{{ $person->address ?: '—' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="mb-0">
                            <dt>LinkedIn</dt>
                            <dd>
                                @if($person->linkedIn_url)
                                    <a href="{{ $person->linkedIn_url }}" target="_blank" rel="noopener">{{ $person->linkedIn_url }}</a>
                                @else — @endif
                            </dd>
                            <dt>{{ __('admin.ui.joined') }}</dt><dd>{{ $person->created_at ? $person->created_at->format('j F Y') : '—' }}</dd>
                            <dt>{{ __('admin.ui.last_seen') }}</dt>
                            <dd>
                                @if($person->isOnline())
                                    Online now
                                @else
                                    {{ $person->last_seen_at ? $person->last_seen_at->diffForHumans().' ('.$person->last_seen_at->format('j M Y, g:ia').')' : 'Never signed in' }}
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                @if($person->about)
                <div class="separator-solid my-3"></div>
                <dl class="member-facts mb-0">
                    <dt>About</dt>
                    <dd class="mb-0">{{ $person->about }}</dd>
                </dl>
                @endif
            </div>
        </div>
    </div>

    {{-- What they have added, at a glance --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    @php
                        $stats = [
                            'Experience' => count($experiences),
                            'Education' => count($educations),
                            'Projects' => count($projects),
                            'Services' => count($services),
                            'Testimonials' => count($testimonials),
                            'Blog posts' => count($blogs),
                            'Messages' => count($messages),
                            'Visits' => $visits,
                        ];
                    @endphp
                    @foreach($stats as $label => $value)
                    <div class="col-6 col-md-3 col-xl-auto" style="min-width: 130px;">
                        <div class="member-stat">
                            <b>{{ $value }}</b>
                            <span>{{ $label }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Experience --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">Experience <span class="badge bg-light text-dark ms-1">{{ count($experiences) }}</span></div></div>
            <div class="card-body">
                @if(count($experiences))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>{{ __('admin.ui.role') }}</th><th>{{ __('admin.ui.company') }}</th><th>{{ __('admin.ui.dates') }}</th><th>{{ __('admin.ui.status') }}</th></tr></thead>
                        <tbody>
                            @foreach($experiences as $item)
                            <tr>
                                <td><b>{{ $item->role }}</b></td>
                                <td>{{ $item->company }}</td>
                                <td>{{ $item->start_date ? date('F Y', strtotime($item->start_date)) : '—' }} – {{ $item->end_date ? date('F Y', strtotime($item->end_date)) : 'Now' }}</td>
                                <td>@if($item->status)<span class="badge bg-success">{{ __('admin.ui.shown') }}</span>@else<span class="badge bg-secondary">{{ __('admin.ui.hidden') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_experience') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Education --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">Education <span class="badge bg-light text-dark ms-1">{{ count($educations) }}</span></div></div>
            <div class="card-body">
                @if(count($educations))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>{{ __('admin.ui.institution') }}</th><th>{{ __('admin.ui.certificate') }}</th><th>{{ __('admin.ui.year') }}</th><th>{{ __('admin.ui.status') }}</th></tr></thead>
                        <tbody>
                            @foreach($educations as $item)
                            <tr>
                                <td><b>{{ $item->institution }}</b></td>
                                <td>{{ $item->certificate }}</td>
                                <td>{{ $item->year ?: '—' }}</td>
                                <td>@if($item->status)<span class="badge bg-success">{{ __('admin.ui.shown') }}</span>@else<span class="badge bg-secondary">{{ __('admin.ui.hidden') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_education') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Projects --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">Projects <span class="badge bg-light text-dark ms-1">{{ count($projects) }}</span></div></div>
            <div class="card-body">
                @if(count($projects))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>Project</th><th>{{ __('admin.ui.company') }}</th><th>{{ __('admin.ui.dates') }}</th><th>{{ __('admin.ui.status') }}</th></tr></thead>
                        <tbody>
                            @foreach($projects as $item)
                            <tr>
                                <td><b>{{ $item->name }}</b></td>
                                <td>{{ $item->company ?: '—' }}</td>
                                <td>{{ $item->start_date ? date('F Y', strtotime($item->start_date)) : '—' }} – {{ $item->end_date ? date('F Y', strtotime($item->end_date)) : 'Now' }}</td>
                                <td>@if($item->status)<span class="badge bg-success">{{ __('admin.ui.shown') }}</span>@else<span class="badge bg-secondary">{{ __('admin.ui.hidden') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_projects') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Services --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">Services <span class="badge bg-light text-dark ms-1">{{ count($services) }}</span></div></div>
            <div class="card-body">
                @if(count($services))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>Service</th><th>{{ __('admin.ui.description') }}</th><th>{{ __('admin.ui.status') }}</th></tr></thead>
                        <tbody>
                            @foreach($services as $item)
                            <tr>
                                <td>@if($item->icon)<i class="{{ $item->icon }} me-2"></i>@endif<b>{{ $item->title }}</b></td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags((string) $item->description), 120) }}</td>
                                <td>@if($item->status)<span class="badge bg-success">{{ __('admin.ui.shown') }}</span>@else<span class="badge bg-secondary">{{ __('admin.ui.hidden') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_services') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Testimonials --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">Testimonials <span class="badge bg-light text-dark ms-1">{{ count($testimonials) }}</span></div></div>
            <div class="card-body">
                @if(count($testimonials))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>{{ __('admin.ui.from') }}</th><th>{{ __('admin.ui.message') }}</th><th>{{ __('admin.ui.rating') }}</th><th>{{ __('admin.ui.status') }}</th></tr></thead>
                        <tbody>
                            @foreach($testimonials as $item)
                            <tr>
                                <td><b>{{ $item->name }}</b>@if($item->position)<div class="text-muted text-small">{{ $item->position }}</div>@endif</td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags((string) $item->message), 120) }}</td>
                                <td>{{ $item->rating ? $item->rating.'/5' : '—' }}</td>
                                <td>@if($item->status)<span class="badge bg-success">{{ __('admin.ui.shown') }}</span>@else<span class="badge bg-secondary">{{ __('admin.ui.hidden') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_testimonials') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Blog posts --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">Blog posts <span class="badge bg-light text-dark ms-1">{{ count($blogs) }}</span></div></div>
            <div class="card-body">
                @if(count($blogs))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>{{ __('admin.ui.title') }}</th><th>{{ __('admin.ui.written') }}</th><th>{{ __('admin.ui.status') }}</th></tr></thead>
                        <tbody>
                            @foreach($blogs as $item)
                            <tr>
                                <td>
                                    <b>{{ $item->title }}</b>
                                    @if($item->status)
                                    <a href="{{ route('front.post', [$item->id, $person->routeKey()]) }}" target="_blank" rel="noopener" class="text-small ms-1">open</a>
                                    @endif
                                </td>
                                <td>{{ $item->created_at ? $item->created_at->format('j M Y') : '—' }}</td>
                                <td>@if($item->status)<span class="badge bg-success">{{ __('admin.ui.published') }}</span>@else<span class="badge bg-secondary">{{ __('admin.ui.draft') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_blog_posts') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Messages received --}}
    <div class="col-md-12">
        <div class="card member-section">
            <div class="card-header"><div class="card-title">{{ __('admin.ui.messages_received') }} <span class="badge bg-light text-dark ms-1">{{ count($messages) }}</span></div></div>
            <div class="card-body">
                @if(count($messages))
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead><tr><th>{{ __('admin.ui.from') }}</th><th>{{ __('admin.ui.subject') }}</th><th>{{ __('admin.ui.received') }}</th><th>{{ __('admin.ui.read') }}</th></tr></thead>
                        <tbody>
                            @foreach($messages as $item)
                            <tr>
                                <td><b>{{ $item->name }}</b><div class="text-muted text-small">{{ $item->email }}</div></td>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->created_at ? $item->created_at->format('j M Y') : '—' }}</td>
                                <td>@if($item->read_status)<span class="badge bg-light text-dark">{{ __('admin.ui.read') }}</span>@else<span class="badge bg-danger">{{ __('admin.ui.unread') }}</span>@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="member-empty">{{ __('admin.ui.no_messages') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>

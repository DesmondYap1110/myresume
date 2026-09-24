@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

@push('script')
<script>
    // The two date boxes only mean anything for "Custom range"; every other
    // period works its own dates out.
    (function () {
        var period = document.getElementById('period');
        if (!period) return;

        var custom = document.querySelectorAll('#visitor-filter .visitor-custom');

        function show() {
            custom.forEach(function (el) { el.hidden = period.value !== 'custom'; });
        }

        period.addEventListener('change', show);
        show();
    })();
</script>
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .visitor-table td { vertical-align: middle; }
        .visitor-ip { font-family: monospace; font-size: .85rem; }
        .visitor-where b { display: block; }
        .visitor-url { display: inline-block; max-width: 320px; overflow: hidden; text-overflow: ellipsis;
            white-space: nowrap; vertical-align: bottom; font-size: .82rem; color: #6c757d; }
        .visitor-agent { display: block; max-width: 320px; overflow: hidden; text-overflow: ellipsis;
            white-space: nowrap; font-size: .75rem; color: #adb5bd; }
        .visitor-when b { display: block; }
        .visitor-stat { border-radius: .5rem; background: #f8f9fa; padding: .85rem 1rem; height: 100%; }
        .visitor-stat b { display: block; font-size: 1.5rem; line-height: 1.1; color: #212529; }
        .visitor-stat span { color: #6c757d; font-size: .82rem; }
        .visitor-filter-bar { padding: 18px 20px; border-top: 1px solid #ebedf2; }
        .visitor-filter { display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end; }
        .visitor-field { display: flex; flex-direction: column; gap: 6px; min-width: 170px; }
        .visitor-field label { margin: 0; font-size: .82rem; font-weight: 600; color: #6c757d; }
        .visitor-field .form-control { height: 44px; }
        .visitor-actions { display: flex; gap: 10px; }
        .visitor-actions .btn { height: 44px; display: inline-flex; align-items: center; font-weight: 600; }
        .visitor-range { display: flex; flex-wrap: wrap; gap: 12px; justify-content: space-between;
            padding: 12px 20px; border-top: 1px solid #ebedf2; font-size: .88rem; color: var(--brand-link, #1572E8); }
        @media (max-width: 575px) {
            .visitor-field, .visitor-actions { width: 100%; }
            .visitor-actions .btn { flex: 1; justify-content: center; }
        }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    @php
                        // The first two follow the filter; Today always means today.
                        $scope = $filter['on'] ? ' in range' : '';
                    @endphp
                    @foreach (['Total visits'.$scope => $totals['visits'], 'Unique addresses'.$scope => $totals['visitors'], 'Today' => $totals['today']] as $label => $value)
                    <div class="col-6 col-md-3" style="min-width: 140px;">
                        <div class="visitor-stat">
                            <b>{{ number_format($value) }}</b>
                            <span>{{ $label }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Who visited your website</div>
                </div>
                <div class="card-category">Newest first. Locations are worked out from the address the visit came from.</div>
            </div>

            <div class="visitor-filter-bar">
                <form method="GET" action="{{ route('visitor.view') }}" class="visitor-filter" id="visitor-filter">
                    <div class="visitor-field">
                        <label for="period">Period</label>
                        <select class="form-control form-select" id="period" name="period">
                            @foreach($filter['periods'] as $key => $label)
                            <option value="{{ $key }}" @selected($filter['period'] === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="visitor-field visitor-custom" @unless($filter['period'] === 'custom') hidden @endunless>
                        <label for="from">From</label>
                        <input type="date" class="form-control" id="from" name="from"
                               value="{{ $filter['period'] === 'custom' ? $filter['from'] : '' }}" max="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="visitor-field visitor-custom" @unless($filter['period'] === 'custom') hidden @endunless>
                        <label for="to">To</label>
                        <input type="date" class="form-control" id="to" name="to"
                               value="{{ $filter['period'] === 'custom' ? $filter['to'] : '' }}" max="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="visitor-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-filter me-1"></i> Apply
                        </button>
                        <a href="{{ route('visitor.view') }}" class="btn btn-light">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </form>

                @error('from')<span class="text-danger d-block mt-2">{{ $message }}</span>@enderror
                @error('to')<span class="text-danger d-block mt-2">{{ $message }}</span>@enderror
            </div>

            <div class="visitor-range">
                <span>{{ $filter['label'] }}</span>
                <span class="text-muted">{{ number_format($visits->total()) }} {{ Str::plural('visit', $visits->total()) }}</span>
            </div>
            <div class="card-body">
                @if($visits->total())
                <div class="table-responsive">
                    <table class="table table-hover visitor-table">
                        <thead>
                            <tr>
                                <th>IP address</th>
                                <th>Location</th>
                                <th>Page</th>
                                <th>When</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visits as $visit)
                            <tr>
                                <td class="visitor-ip">{{ $visit->ip_address ?: '—' }}</td>
                                <td class="visitor-where">
                                    @if($visit->country)
                                        <b>{{ $visit->country }}</b>
                                        @if($visit->city)<span class="text-muted text-small">{{ $visit->city }}</span>@endif
                                    @elseif($visit->located_at)
                                        <span class="text-muted text-small">Unknown</span>
                                    @else
                                        <span class="text-muted text-small">Looking up…</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="visitor-url" title="{{ $visit->url }}">{{ $visit->url ?: '—' }}</span>
                                    <span class="visitor-agent" title="{{ $visit->user_agent }}">{{ $visit->user_agent ?: '' }}</span>
                                </td>
                                <td class="visitor-when">
                                    <b>{{ $visit->created_at?->format('j M Y, g:ia') }}</b>
                                    <span class="text-muted text-small">{{ $visit->created_at?->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- This admin is Bootstrap; Laravel's default paginator markup is Tailwind. --}}
                {{ $visits->links('pagination::bootstrap-5') }}
                @else
                <p class="mb-0 text-muted">
                    {{ $filter['on'] ? 'No visits between those dates.' : 'Nobody has visited your website yet.' }}
                </p>
                @endif
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>

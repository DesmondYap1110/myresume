@push('title')
Dashboard
@endpush

<x-template1.admin.master.master-layout>
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <x-template1.admin.card.card icon="fas fa-users" text="Total Visitors" :data="$all_visit_log" />
        <x-template1.admin.card.card icon="fas fa-user" text="Visitors Today" :data="$visit_log" />
        <x-template1.admin.card.card icon="fas fa-envelope" text="Inbox Messages" :data="$inbox" />
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Visitor Statistics</div>
                        @if(!request()->header('User-Agent') || !Str::contains(request()->header('User-Agent'), ['Mobile', 'Android', 'iPhone']))
                        <div class="card-tools">
                            <a href="javascript:void(0);" class="btn btn-label-info btn-round btn-sm" onclick="printChart()">
                                <span class="btn-label"><i class="fa fa-print"></i></span>Print
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" id="print-area" style="min-height: 200px">
                        <canvas id="statisticsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Today's Visitors <span class="badge bg-light text-dark ms-1">{{ number_format($recent_total) }}</span></div>
                        <div class="card-tools">
                            <a href="{{ route('visitor.view') }}" class="btn btn-label-info btn-round btn-sm">See all</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($recent_visits))
                    <div class="table-responsive">
                        <table class="table table-hover dash-visitors">
                            <thead>
                                <tr>
                                    <th>IP address</th>
                                    <th>Location</th>
                                    <th>Page</th>
                                    <th>When</th>
                                </tr>
                            </thead>
                            <tbody id="visitor-rows">
                                @foreach($recent_visits as $visit)
                                <tr>
                                    <td class="dash-ip">{{ $visit->ip_address ?: '—' }}</td>
                                    <td>
                                        @if($visit->country)
                                            <b>{{ $visit->country }}</b>
                                            @if($visit->city)<div class="text-muted text-small">{{ $visit->city }}</div>@endif
                                        @else
                                            <span class="text-muted text-small">{{ $visit->located_at ? 'Unknown' : 'Looking up…' }}</span>
                                        @endif
                                    </td>
                                    <td><span class="dash-url" title="{{ $visit->url }}">{{ $visit->url ?: '—' }}</span></td>
                                    <td>
                                        <b>{{ $visit->created_at?->format('j M Y, g:ia') }}</b>
                                        <div class="text-muted text-small">{{ $visit->created_at?->diffForHumans() }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($recent_total > count($recent_visits))
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-light btn-round btn-sm" id="visitor-more"
                                data-url="{{ route('visitor.today') }}" data-offset="{{ count($recent_visits) }}">
                            Load more
                        </button>
                    </div>
                    @endif
                    @else
                    <p class="mb-0 text-muted">Nobody has visited your website today.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Later visitors are fetched only when asked for, so a busy day costs
        // the dashboard nothing until somebody wants to look.
        (function () {
            var button = document.getElementById('visitor-more');
            var body = document.getElementById('visitor-rows');

            if (!button || !body) return;

            function cell(row, text, className) {
                var td = row.insertCell();
                td.textContent = text == null ? '' : text;
                if (className) td.className = className;
                return td;
            }

            button.addEventListener('click', function () {
                button.disabled = true;
                button.textContent = 'Loading…';

                fetch(button.dataset.url + '?offset=' + button.dataset.offset, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin'
                })
                    .then(function (r) { return r.ok ? r.json() : Promise.reject(r.status); })
                    .then(function (data) {
                        data.rows.forEach(function (v) {
                            var row = body.insertRow();

                            cell(row, v.ip, 'dash-ip');
                            cell(row, v.where);

                            var url = row.insertCell();
                            var span = document.createElement('span');
                            span.className = 'dash-url';
                            span.title = v.url;
                            span.textContent = v.url;
                            url.appendChild(span);

                            var when = row.insertCell();
                            var at = document.createElement('b');
                            at.textContent = v.at;
                            var ago = document.createElement('div');
                            ago.className = 'text-muted text-small';
                            ago.textContent = v.ago;
                            when.appendChild(at);
                            when.appendChild(ago);
                        });

                        button.dataset.offset = data.next;

                        if (data.more) {
                            button.disabled = false;
                            button.textContent = 'Load more';
                        } else {
                            button.remove();
                        }
                    })
                    .catch(function () {
                        button.disabled = false;
                        button.textContent = 'Load more';
                    });
            });
        })();
    </script>

    <style>
        .dash-visitors td { vertical-align: middle; }
        .dash-ip { font-family: monospace; font-size: .85rem; }
        .dash-url { display: inline-block; max-width: 320px; overflow: hidden; text-overflow: ellipsis;
            white-space: nowrap; vertical-align: bottom; font-size: .82rem; color: #6c757d; }
    </style>
</x-template1.admin.master.master-layout>

<script>
const ctx = document.getElementById('statisticsChart').getContext('2d');

const data_visit = @json($data_visit);

// last 7 days labels
const period = Object.keys(data_visit);

// fake views data
const data = Object.values(data_visit);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: period,
        datasets: [{
            label: 'Views (Last 7 Days)',
            data: data,
            borderWidth: 2,
            tension: 0.2,
            backgroundColor: 'rgba(255, 215, 0, 0.6)',
            borderColor: 'rgba(255, 215, 0, 1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {

            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 2,
                    precision: 0
                }
            }
        }
    }
});

function printChart()
{
    window.print();
}
</script>


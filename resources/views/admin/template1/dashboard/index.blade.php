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


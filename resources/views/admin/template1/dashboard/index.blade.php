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
        <x-template1.admin.card.card icon="fas fa-user" text="Total Visitors" :data="$visit_log" />
        <x-template1.admin.card.card icon="fas fa-user" text="Visitors Today" :data="$visit_log" />
        <x-template1.admin.card.card icon="fas fa-envelope" text="Inbox Messages" :data="$inbox" />
    </div>
</x-template1.admin.master.master-layout>


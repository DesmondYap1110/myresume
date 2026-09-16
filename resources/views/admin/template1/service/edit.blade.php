@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Service</div>
            </div>
            <form action="{{ route('service.update', $service_detail->id) }}" method="post">
                @csrf
                <x-template1.admin.form.service-fields :icons="$icons" :service="$service_detail" />
                <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                    <a href="{{ route('service.view') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>

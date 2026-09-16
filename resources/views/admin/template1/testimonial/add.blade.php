@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-10 col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Add Testimonial</div>
            </div>
            <form action="{{ route('testimonial.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <x-template1.admin.form.testimonial-fields />
                <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                    <a href="{{ route('testimonial.view') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>

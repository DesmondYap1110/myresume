@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ __('admin.ui.add_person') }}</div>
                <div class="card-category">Creates an account that can sign in and build its own portfolio.</div>
            </div>
            <form action="{{ route('member.create') }}" method="post">
                @csrf
                <x-template1.admin.form.member-fields />
                <div class="card-action">
                    <button type="submit" class="btn btn-dark">{{ __('admin.ui.create_account') }}</button>
                    <a href="{{ route('member.view') }}" class="btn btn-black btn-border">{{ __('admin.ui.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>

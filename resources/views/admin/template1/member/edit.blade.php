@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit {{ $person->name }}</div>
                <div class="card-category">
                    Website: <a href="{{ route('front.show', $person->routeKey()) }}" target="_blank" rel="noopener">{{ route('front.show', $person->routeKey()) }}</a>
                </div>
            </div>
            <form action="{{ route('member.update', $person->id) }}" method="post">
                @csrf
                <x-template1.admin.form.member-fields :person="$person" />
                <div class="card-action">
                    <button type="submit" class="btn btn-dark">Save changes</button>
                    <a href="{{ route('member.view') }}" class="btn btn-black btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>

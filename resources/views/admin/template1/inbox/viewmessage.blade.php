@push('title')
{{$breadcrumbs['list']['0']['text']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Subject:<span class="text-black">&nbsp;{{$inbox->subject}}&nbsp;</span></div>
                </div>
            </div>
            <div class="card-action">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                        <div class="form-check d-flex align-items-center">
                            <input
                                class="form-check-input mark-read"
                                type="checkbox"
                                onclick="updateStatus()"
                                @if($inbox->read_status) checked @endif
                            >

                            <label class="mb-0">{{ __('admin.ui.mark_as_read') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                        <label for="name">{{ __('admin.ui.name') }} </label>
                        <input type="text" class="form-control" id="company" disabled name="name" value="{{$inbox->name}}">
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12 py-1">
                        <label for="email"> {{ __('admin.ui.email') }}</label>
                        <input type="text" class="form-control" id="position" disabled name="email" value="{{$inbox->email}}">
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 py-1">
                        <label for="description"> {{ __('admin.ui.description') }} </label>
                        {{-- Escaped: this text comes from the public contact form. --}}
                        <textarea name="detail" rows="6" class="form-control" disabled>{{ $inbox->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>

<script>
function updateStatus()
{

    $.ajax({
        url: "{{route('inbox.status2',request()->route('id'))}}",
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response)
        {
            console.log(response.message);
        }
    });
}

</script>

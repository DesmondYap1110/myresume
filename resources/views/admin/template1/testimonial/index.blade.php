@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Testimonials</div>
                    <div class="card-tools">
                        <a href="{{ route('testimonial.add') }}" class="btn bg-black btn-icon text-white" data-toggle="tooltip" data-placement="bottom" title="{{ __('admin.ui.add_testimonial') }}">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-category">{{ __('admin.ui.clients_say') }}</div>
            </div>
            <div class="card-body">
                @if(count($testimonial))
                <div class="row">
                    @foreach($testimonial as $data)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-round">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    @if($data->image)
                                    <img src="{{ $data->image }}" alt="{{ $data->name }}" class="rounded-circle me-3" style="width:52px;height:52px;object-fit:cover">
                                    @else
                                    <span class="rounded-circle me-3 d-inline-flex align-items-center justify-content-center fw-bold"
                                          style="width:52px;height:52px;background:var(--brand-primary,#212529);color:var(--brand-button-text,#FFD700)">{{ $data->initials() }}</span>
                                    @endif
                                    <div>
                                        <b>{{ $data->name }}</b>
                                        <div class="text-muted text-small">{{ $data->position }}</div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $data->rating ? '' : 'text-muted opacity-25' }}" style="{{ $i <= $data->rating ? 'color:var(--brand-accent,#FFD700)' : '' }}"></i>
                                    @endfor
                                    <span class="text-muted text-small ms-2">Order {{ $data->sort_order }}</span>
                                </div>
                                <p class="text-muted fst-italic mb-0">"{{ Str::limit($data->message, 160) }}"</p>
                            </div>
                            <div class="card-header d-flex justify-content-end align-items-center">
                                <a href="{{ route('testimonial.edit', $data->id) }}" class="btn btn-success btn-sm m-1">{{ __('admin.ui.edit') }}</a>
                                <a href="{{ route('testimonial.delete', $data->id) }}" class="btn btn-danger btn-sm m-1" data-confirm="{{ __('admin.confirm.q_delete_testimonial') }}" data-confirm-title="{{ __('admin.confirm.t_delete_testimonial') }}" data-confirm-ok="{{ __('admin.confirm.ok_delete') }}">{{ __('admin.ui.delete') }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    Empty {{$breadcrumbs['CurrentPage']}}. Add <a href="{{ route('testimonial.add') }}">{{$breadcrumbs['CurrentPage']}}</a>.
                </div>
                @endif
            </div>
        </div>
    </div>
</x-template1.admin.master.master-layout>

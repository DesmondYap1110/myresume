@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Password</div>
            </div>
            <div class="form-group form-show-validation row">
                <label for="email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">E-mail <span class="required-label">*</span></label>
                <div class="col-lg-4 col-md-9 col-sm-8">
                    <input type="email" class="form-control" id="email" placeholder="Enter Email" disabled value="{{Auth::user()->email}}">
                </div>
            </div>
            <form action="{{route("setting.update")}}" method="post">
                @csrf
                <div class="form-group form-show-validation row">
                    <label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Password <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                </div>
                <div class="form-group form-show-validation row">
                    <label for="confirmpassword" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Confirm Password <span class="required-label">*</span></label>
                    <div class="col-lg-4 col-md-9 col-sm-8">
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="btn btn-success" type="submit" value="Submit">
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .template-options { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; }
        .template-option input { position: absolute; opacity: 0; pointer-events: none; }
        .template-card { display: block; height: 100%; border: 2px solid #ebedf2; border-radius: 12px; overflow: hidden; background: #fff; cursor: pointer; transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease; }
        .template-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.08); }
        .template-option input:checked + .template-card { border-color: var(--brand-primary, #212529); box-shadow: 0 0 0 3px rgba(0,0,0,.08); }
        .template-option input:focus-visible + .template-card { outline: 2px solid var(--brand-primary, #212529); outline-offset: 2px; }
        .template-shot { display: block; position: relative; aspect-ratio: 16 / 10; background: #f5f7fd center top / cover no-repeat; border-bottom: 1px solid #ebedf2; }
        .template-live { position: absolute; top: 10px; left: 10px; font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 999px; background: #1f9d55; color: #fff; }
        .template-body { display: block; padding: 14px 16px; }
        .template-body b { display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 15px; color: #1a2035; }
        .template-body .tick { width: 22px; height: 22px; border-radius: 50%; border: 2px solid #d5d9e2; flex: 0 0 auto; position: relative; }
        .template-option input:checked + .template-card .tick { border-color: var(--brand-primary, #212529); background: var(--brand-primary, #212529); }
        .template-option input:checked + .template-card .tick::after { content: ""; position: absolute; left: 6px; top: 2px; width: 6px; height: 11px; border: solid var(--brand-button-text, #fff); border-width: 0 2px 2px 0; transform: rotate(45deg); }
        .template-body small { display: block; margin-top: 6px; color: #6c757d; line-height: 1.45; }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Website Template</div>
                <div class="card-category">Choose the design visitors see on your public portfolio.</div>
            </div>
            <form action="{{ route('setting.template') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="template-options" role="radiogroup" aria-label="Website template">
                        @foreach($templates as $key => $template)
                        <label class="template-option mb-0">
                            <input type="radio" name="website_template" value="{{ $key }}" @checked(old('website_template', $currentTemplate) === $key)>
                            <span class="template-card">
                                <span class="template-shot" style="background-image: url('{{ asset($template['preview']) }}')">
                                    @if($currentTemplate === $key)
                                    <span class="template-live">Live</span>
                                    @endif
                                </span>
                                <span class="template-body">
                                    <b>{{ $template['name'] }} <span class="tick"></span></b>
                                    <small>{{ $template['description'] }}</small>
                                </span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success">Save Template</button>
                    <a href="{{ route('front.show', base64_encode(Auth::id())) }}" target="_blank" rel="noopener" class="btn btn-light">
                        <i class="fas fa-external-link-alt me-1"></i> View Website
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>


@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

@push('script')
<script>
    // Saving reloads the page, which would otherwise drop you back on
    // Personal Information. Remember the section being edited and reopen it.
    (function () {
        var key = 'profileTab';
        var tabs = document.querySelectorAll('#pf-tabs [data-bs-toggle="tab"]');

        if (!tabs.length) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('shown.bs.tab', function () {
                try { localStorage.setItem(key, tab.dataset.bsTarget); } catch (e) {}
            });
        });

        var wanted = location.hash || null;

        try { wanted = wanted || localStorage.getItem(key); } catch (e) {}

        var button = wanted && document.querySelector('#pf-tabs [data-bs-target="' + wanted + '"]');

        if (button && window.bootstrap) new bootstrap.Tab(button).show();
    })();
</script>
@endpush
<style>
    /* .img-btn belonged to the old avatar markup; .pf-avatar-btn replaces it. */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1a2035 !important;
        margin-bottom: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        color: white;
    }

    .resume-current { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; padding: 14px 16px; margin-bottom: 20px; border: 1px solid #ebedf2; border-radius: 10px; background: #fafbfd; }
    .resume-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: #fdecea; color: #d93025; font-size: 20px; flex: 0 0 auto; }
    .resume-meta { flex: 1 1 200px; min-width: 0; word-break: break-word; }
    .resume-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    /* Outline and solid buttons differ in border by default; pin both to one box. */
    .resume-actions .resume-btn { display: inline-flex; align-items: center; justify-content: center; height: 36px; padding: 0 16px;
        line-height: 1; border-width: 1px; border-radius: 6px; font-weight: 600; white-space: nowrap; }

    /* Who you are, beside the section being edited. */
    .pf-side { overflow: hidden; }
    .pf-side-top { display: flex; flex-direction: column; align-items: center; text-align: center;
        padding: 24px 18px 20px; border-bottom: 1px solid #ebedf2; }
    .pf-avatar { position: relative; width: 104px; height: 104px; margin-bottom: 14px; }
    .pf-avatar img { width: 104px; height: 104px; border-radius: 50%; object-fit: cover;
        background: #f5f7fd; border: 3px solid #fff; box-shadow: 0 0 0 1px #ebedf2;
        transition: filter .25s ease; }
    .pf-avatar:hover img { filter: brightness(.88); }

    /* Out of the way until the avatar is hovered, so the picture is not
       covered while you are only looking at it. Keyboard focus shows it too,
       otherwise it could never be reached by tabbing. */
    .pf-avatar-btn { position: absolute; right: 0; bottom: 0; width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 13px;
        background: var(--brand-primary, #212529); color: var(--brand-button-text, #fff);
        box-shadow: 0 2px 6px rgba(0, 0, 0, .18);
        opacity: 0; transform: scale(.6) translateY(6px); pointer-events: none;
        transition: opacity .22s ease, transform .22s cubic-bezier(.34, 1.56, .64, 1), background-color .2s ease; }
    .pf-avatar:hover .pf-avatar-btn,
    .pf-avatar:focus-within .pf-avatar-btn {
        opacity: 1; transform: scale(1) translateY(0); pointer-events: auto; }
    .pf-avatar-btn:hover { background: var(--brand-primary-hover, #000); }

    /* A pointer is needed to hover, so on touch the button simply stays. */
    @media (hover: none) {
        .pf-avatar-btn { opacity: 1; transform: none; pointer-events: auto; }
    }

    @media (prefers-reduced-motion: reduce) {
        .pf-avatar-btn { transition: opacity .15s linear; transform: none; }
        .pf-avatar:hover .pf-avatar-btn,
        .pf-avatar:focus-within .pf-avatar-btn { transform: none; }
    }
    .pf-name { font-size: 1.05rem; color: #1a2035; line-height: 1.3; word-break: break-word; }
    .pf-slug { color: #6c757d; font-size: .85rem; margin-top: 2px; word-break: break-all; }
    .pf-side-actions { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-top: 14px; }

    .pf-nav { padding: 8px 0; }
    .pf-nav .nav-link { display: flex; align-items: center; gap: 12px; width: 100%;
        border: 0; border-radius: 0; background: none; text-align: left;
        padding: 13px 20px; font-weight: 600; font-size: .9rem; color: #495057; }
    .pf-nav .nav-link i { width: 18px; text-align: center; font-size: 15px; color: #6c757d; }
    .pf-nav .nav-link:hover { background: #f5f7fd; color: #1a2035; }
    .pf-nav .nav-link.active { background: var(--brand-primary, #212529); color: var(--brand-button-text, #fff); }
    .pf-nav .nav-link.active i { color: var(--brand-button-text, #fff); }

    @media (max-width: 767px) {
        .pf-side-top { padding: 18px 14px 14px; }
        .pf-avatar, .pf-avatar img { width: 84px; height: 84px; }
        /* Side by side would leave each too narrow to read on a phone. */
        .pf-nav { display: flex; flex-direction: row !important; overflow-x: auto; padding: 0; scrollbar-width: none; }
        .pf-nav::-webkit-scrollbar { display: none; }
        .pf-nav .nav-link { white-space: nowrap; padding: 12px 15px; }
    }
</style>
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-12">
            <div class="row pf-layout">

            {{-- Who you are, and the section being edited. --}}
            <div class="col-lg-3 col-md-4">
                <div class="card pf-side">
                    <div class="pf-side-top">
                        <div class="pf-avatar">
                            <img class="img-upload-preview" id="previewImg"
                                 src="{{ $user_detail->image ?: asset('assets/admin/img/default.jpg') }}"
                                 alt="{{ __('admin.ui.profile_image') }}">
                            <input type="file" class="d-none" id="uploadImg" accept="image/*">
                            <label for="uploadImg" class="pf-avatar-btn" title="{{ __('admin.ui.upload') }}">
                                <i class="fa fa-upload"></i>
                            </label>
                        </div>

                        <b class="pf-name">{{ $user_detail->name }}</b>
                        <span class="pf-slug">{{ $user_detail->routeKey() }}</span>

                        <div class="pf-side-actions">
                            <a href="{{ route('front.show', $user_detail->routeKey()) }}" target="_blank" rel="noopener"
                               class="btn btn-light btn-sm">
                                <i class="fas fa-external-link-alt me-1"></i> {{ __('admin.ui.view_website') }}
                            </a>
                        </div>
                    </div>

                    <ul class="nav flex-column pf-nav" id="pf-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pf-tab-personal" data-bs-toggle="tab"
                                    data-bs-target="#pf-personal" type="button" role="tab">
                                <i class="fas fa-user-circle"></i>{{ __('admin.ui.personal_information') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pf-tab-about" data-bs-toggle="tab"
                                    data-bs-target="#pf-about" type="button" role="tab">
                                <i class="fas fa-id-badge"></i>{{ __('admin.ui.about_me') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pf-tab-social" data-bs-toggle="tab"
                                    data-bs-target="#pf-social" type="button" role="tab">
                                <i class="fas fa-share-alt"></i>{{ __('admin.ui.social_links') }}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
            <div class="card">
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf

                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="pf-personal" role="tabpanel" aria-labelledby="pf-tab-personal">
                    <div class="card-action">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 col-12 py-1">
                                        <label for="name">{{ __('admin.ui.name') }} <span>*</span></label>
                                        <input type="text" class="form-control" id="name" placeholder="{{ __('admin.ui.enter_name') }}" value="{{$user_detail->name}}" name="name" required>
                                    </div>
                                    <div class="col-md-6 col-12 py-1">
                                        <label for="email">{{ __('admin.ui.email_address') }}</label>
                                        <input type="email" class="form-control" id="email" placeholder="{{ __('admin.ui.enter_email') }}" value="{{$user_detail->email}}" disabled>
                                    </div>
                                    <div class="col-md-6 col-12 py-1">
                                        <label>{{ __('admin.ui.birthday') }} <span>*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker" name="dob" value="{{$user_detail->dob}}"  required>
                                            <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 py-1">
                                        <label for="default_locale">{{ __('admin.ui.site_language') }}</label>
                                        <select class="form-control" id="default_locale" name="default_locale">
                                            {{-- Empty means follow the visitor's browser, which is
                                                 what every site did before this setting existed. --}}
                                            <option value="">{{ __('admin.ui.site_language_auto') }}</option>
                                            @foreach((array) config('locales.supported', []) as $code => $locale)
                                            <option value="{{ $code }}" @selected($user_detail->default_locale === $code)>{{ $locale['native'] ?? $code }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- The number now comes from the WhatsApp row under
                                         Social Links, so it is only asked for once. --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-12 py-3">
                                <label for="name">{{ __('admin.ui.address') }} <span>*</span></label>
                                <input type="text" class="form-control" id="address" placeholder="{{ __('admin.ui.enter_address') }}" value="{{$user_detail->address}}" name="address" required>
                            </div>
                            {{-- LinkedIn is one of the rows under Social Links now. --}}
                            <div class="col-md-12 col-lg-12 py-1">
                                <label for="slug">{{ __('admin.ui.my_website_url') }} <span>*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ rtrim(url('/'), '/') }}/</span>
                                    <input type="text" class="form-control" id="slug" name="slug" required minlength="3" maxlength="60"
                                           pattern="[a-z0-9]+(-[a-z0-9]+)*" placeholder="desmond-yap"
                                           value="{{ old('slug', $user_detail->slug ?: base64_encode($user_detail->id)) }}"
                                           aria-describedby="slug-help">
                                </div>
                                <small id="slug-help" class="form-text text-muted">
                                    {!! __('admin.ui.slug_help', ['example' => '<b>desmond-yap</b>']) !!}
                                </small>
                                @error('slug')<span class="text-danger d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-12 col-lg-12 py-1">
                                <label>{{ __('admin.ui.share_this_link') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ route('front.show', $user_detail->routeKey()) }}" id="textToCopy" disabled>
                                    <button class="btn btn-black btn-border" id="copyBtn" type="button">{{ __('admin.ui.copy') }}</button>
                                    <a class="btn btn-black btn-border" href="{{ route('front.show', $user_detail->routeKey()) }}" target="_blank" rel="noopener">{{ __('admin.ui.open') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>{{-- /Personal Information --}}

                    <div class="tab-pane fade" id="pf-about" role="tabpanel" aria-labelledby="pf-tab-about">
                        {{-- Position and About Me differ per language. --}}
                        <div class="card-action">
                            <x-template1.admin.lang-fields
                                :model="$user_detail"
                                :fields="[
                                    'role' => ['label' => __('admin.ui.position_role'), 'type' => 'text', 'required' => true, 'width' => 'col-12'],
                                    'about' => ['label' => __('admin.ui.about_me'), 'type' => 'rich'],
                                ]" />
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pf-social" role="tabpanel" aria-labelledby="pf-tab-social">
                        <div class="card-action">
                            <x-template1.admin.social-links :user="$user_detail" />
                        </div>
                    </div>
                    </div>{{-- /tab-content --}}

                    <div class="card-action">
                        <button type = "submit" class="btn btn-dark">{{ __('admin.ui.save_changes') }}</button>
                    </div>
                </form>
            </div>

            {{-- Separate from the form above: a file upload cannot sit inside it. --}}
            <div class="card" id="resume" data-pf-resume>
                <div class="card-header">
                    <div class="card-title">{{ __('admin.ui.resume_cv') }}</div>
                </div>
                <div class="card-body">
                    @if($user_detail->hasResume())
                    <div class="resume-current">
                        <span class="resume-icon"><i class="fa fa-file-pdf"></i></span>
                        <div class="resume-meta">
                            <b>{{ $user_detail->resumeDownloadName() }}</b>
                            {{-- trans_choice picks the right form per language;
                                 Malay and Chinese do not change the noun. --}}
                            <small class="text-muted d-block">
                                {{ trans_choice('admin.resume.jobs', $resumeStats['experience'], ['count' => $resumeStats['experience']]) }}
                                · {{ trans_choice('admin.resume.qualifications', $resumeStats['education'], ['count' => $resumeStats['education']]) }}
                                · {{ trans_choice('admin.resume.strengths', $resumeStats['services'], ['count' => $resumeStats['services']]) }}
                                @if($resumeStats['projects']) · {{ trans_choice('admin.resume.projects', $resumeStats['projects'], ['count' => $resumeStats['projects']]) }}@endif
                            </small>
                        </div>
                        {{-- Same size and shape for both, so they line up. --}}
                        <div class="resume-actions">
                            <a href="{{ route('profile.resume') }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-dark resume-btn"><i class="fa fa-eye me-1"></i> {{ __('admin.ui.preview') }}</a>
                            <a href="{{ route('profile.resume', ['download' => 1]) }}" class="btn btn-sm btn-dark resume-btn"><i class="fa fa-download me-1"></i> {{ __('admin.resume.generate_download') }}</a>
                        </div>
                    </div>
                    @else
                    <p class="themed-note mb-0">
                        <i class="fas fa-info-circle"></i>
                        <span>{!! __('admin.resume.empty_note', ['button' => '<b>'.e(__('admin.ui.download_cv')).'</b>']) !!}</span>
                    </p>
                    @endif
                </div>
            </div>
            </div>{{-- /right column --}}

            </div>{{-- /pf-layout --}}
        </div>
</x-template1.admin.master.master-layout>

<script>
    $('.js-example-basic-single').select2({
        placeholder: 'Select Language'
    });

    $('#datepicker').datetimepicker('date', moment('{{$user_detail->dob}}'));

    // JavaScript
    $('#uploadImg').on('change', function () {
        let file = this.files[0];

        if (!file) return;

        let formData = new FormData();
        formData.append('uploadImg', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('profile.upload') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success)
                {
                    $('#previewImg').attr('src', res.url);
                    $.notify("Image uploaded successfully", "success");
                }
                else
                {
                    $.notify(res.message, "error");
                }
            },
            error: function(xhr) {
                let message = 'Upload failed';
                if (xhr.responseJSON && xhr.responseJSON.message)
                {
                    message = xhr.responseJSON.message;
                }
                else if (xhr.responseJSON && xhr.responseJSON.errors)
                {
                    message = Object.values(xhr.responseJSON.errors)[0][0];
                }
                $.notify(message, "error");
            }
        });
    });

    $(document).ready(function() {
        $("#copyBtn").click(function() {
            var text = $("#textToCopy").val();

            // Create temporary textarea
            var temp = $("<textarea>");
            $("body").append(temp);
            temp.val(text).select();

            // Copy text
            document.execCommand("copy");

            // Remove temp element
            temp.remove();

            adminAlert("The link has been copied to your clipboard.", "Copied");
        });
    });

</script>


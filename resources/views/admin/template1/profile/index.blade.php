@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush
<style>
    .img-btn{
        opacity: 0 !important;
    }
    .img-btn:hover{
        opacity: 1 !important;
    }
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
    .resume-actions { display: flex; flex-wrap: wrap; gap: 8px; }


</style>
<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <div class="card-action">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-12 d-flex justify-content-center align-items-center">
                                <div class="input-file input-file-image ">
                                    <div class="d-flex justify-content-center align-items-center">
                                            @if($user_detail->image)
                                                <img class="img-upload-preview img-circle" id="previewImg" width="150" height="150" src="{{ $user_detail->image }}" alt="preview">
                                            @else
                                                <img class="img-upload-preview img-circle" id="previewImg" width="150" height="150" src="{{ asset('assets/admin/img/default.jpg') }}" alt="preview">
                                            @endif
                                        <input type="file" class="d-none" id="uploadImg" accept="image/*" >
                                        <label for="uploadImg" class="btn btn-primary btn-sm  rounded-circle img-btn position-absolute" ><i class="fa fa-upload"></i></label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label for="name">Name <span>*</span></label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Name" value="{{$user_detail->name}}" name="name" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email" value="{{$user_detail->email}}" disabled>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label>Birthday <span>*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker" name="dob" value="{{$user_detail->dob}}"  required>
                                            <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label for="phone">Phone <span>*</span></label>
                                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone" value="{{$user_detail->phone}}" name="phone" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 py-3">
                                <label for="position">Position Role <span>*</span></label>
                                <input type="text" class="form-control" id="position" placeholder="Enter Position Role" value="{{$user_detail->role}}" name="role" required>
                            </div>
                            <div class="col-md-6 col-lg-4 py-3">
                                <label for="name">Address <span>*</span></label>
                                <input type="text" class="form-control" id="address" placeholder="Enter Address" value="{{$user_detail->address}}" name="address" required>
                            </div>
                            <div class="col-md-6 col-lg-4 py-3">
                                <label for="linkedinURL">LinkedIn URL <span>*</span></label>
                                <input type="text" class="form-control" id="linkedinURL" placeholder="Enter linkedIn URL" value="{{$user_detail->linkedIn_url}}" name="linkedIn_url" required>
                            </div>
                            <div class="col-md-12 col-lg-12 py-1">
                                <label for="slug">My Website URL <span>*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ rtrim(url('/'), '/') }}/</span>
                                    <input type="text" class="form-control" id="slug" name="slug" required minlength="3" maxlength="60"
                                           pattern="[a-z0-9]+(-[a-z0-9]+)*" placeholder="desmond-yap"
                                           value="{{ old('slug', $user_detail->slug ?: base64_encode($user_detail->id)) }}"
                                           aria-describedby="slug-help">
                                </div>
                                <small id="slug-help" class="form-text text-muted">
                                    Lowercase letters, numbers and hyphens, e.g. <b>desmond-yap</b>. Changing it changes your website link, and the old link will redirect here.
                                </small>
                                @error('slug')<span class="text-danger d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-12 col-lg-12 py-1">
                                <label>Share this link</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ route('front.show', $user_detail->routeKey()) }}" id="textToCopy" disabled>
                                    <button class="btn btn-black btn-border" id="copyBtn" type="button">Copy</button>
                                    <a class="btn btn-black btn-border" href="{{ route('front.show', $user_detail->routeKey()) }}" target="_blank" rel="noopener">Open</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-title summertext" data-placeholder = "About Me...">About Me</div>
                        <textarea name="about" id="summernote" class="form-control">{!! $user_detail->about !!}</textarea>
                    </div>
                    <div class="card-action">
                        <button type = "submit" class="btn btn-dark">Edit</button>
                    </div>
                </form>
            </div>

            {{-- Separate from the form above: a file upload cannot sit inside it. --}}
            <div class="card" id="resume">
                <div class="card-header">
                    <div class="card-title">Resume / CV</div>
                    <div class="card-category">A PDF visitors can download from the <b>Download CV</b> button on your website.</div>
                </div>
                <div class="card-body">
                    @if($user_detail->hasResume())
                    <div class="resume-current">
                        <span class="resume-icon"><i class="fa fa-file-pdf"></i></span>
                        <div class="resume-meta">
                            <b>{{ $user_detail->resume_name ?: 'resume.pdf' }}</b>
                            <small class="text-muted d-block">
                                {{ number_format(filesize($user_detail->resumePath()) / 1024) }} KB
                                @if($user_detail->resume_uploaded_at) · uploaded {{ $user_detail->resume_uploaded_at->diffForHumans() }}@endif
                            </small>
                        </div>
                        <div class="resume-actions">
                            <a href="{{ $user_detail->resumeUrl() }}" class="btn btn-sm btn-black btn-border"><i class="fa fa-download me-1"></i> Download</a>
                            <form action="{{ route('profile.resume.delete') }}" method="post" class="d-inline"
                                  onsubmit="return confirm('Remove your resume from the website?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash me-1"></i> Remove</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <p class="text-muted mb-3">No resume uploaded yet — the <b>Download CV</b> button stays hidden on your website until you add one.</p>
                    @endif

                    <form action="{{ route('profile.resume.upload') }}" method="post" enctype="multipart/form-data" class="resume-upload">
                        @csrf
                        <label for="resumeFile" class="form-label">{{ $user_detail->hasResume() ? 'Replace with a new PDF' : 'Upload a PDF' }}</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="resumeFile" name="resume" accept="application/pdf,.pdf" required>
                            <button type="submit" class="btn btn-dark"><i class="fa fa-upload me-1"></i> Upload</button>
                        </div>
                        <small class="form-text text-muted">PDF only, up to 5 MB. Kept outside the public folder and always sent as a download.</small>
                        @error('resume')<span class="text-danger d-block">{{ $message }}</span>@enderror
                    </form>
                </div>
            </div>
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

            alert("Copied!");
        });
    });

</script>


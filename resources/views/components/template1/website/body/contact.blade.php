<section class="resume-section p-3 p-lg-5 d-flex flex-column">
    <div class="row my-auto" id="contact">
    <div class="col-md-8">
        <div class="contact-cont">
        <h3>CONTACT Us</h3>
        </div>
        <form action="{{route('front.contact',request()->id)}}" method="post">
        @csrf
                        <x-website.form-guard />
            <div class="row con-form">

                    @if(session('success'))
                    <div class="col-md-12"><div class="alert alert-success" role="alert">Thank you! Your message has been sent.</div></div>
                    @endif
                    @if($errors->any())
                    <div class="col-md-12"><div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div></div>
                    @endif

                    <div class="col-md-12">
                        <input type="text" name="name" placeholder="Full Name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                    </div>
                    <div class="col-md-12">
                        <input type="email" name="email" placeholder="Email Id" class="form-control" value="{{ old('email') }}" required maxlength="255">
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="subject" placeholder="Subject" class="form-control" value="{{ old('subject') }}" maxlength="255">
                    </div>
                    <div class="col-md-12"><textarea name="description" placeholder="Your Message" required maxlength="5000">{{ old('description') }}</textarea></div>
                    <div class="col-md-12 captcha-row">
                        <div class="captcha-field"><x-website.captcha theme="dark" /></div>
                        <div class="sub-but"><button class="btn btn-general btn-white" type="submit">Send</button></div>
                    </div>

            </div>
        </form>
    </div>
    <div class="col-md-4 col-sm-12 mt-5">
        <div class="contact-cont2">
        @if($user->address)
        <div class="contact-add contact-box-desc">
            <h3><i class="fa fa-map-marker cl-atlantis fa-2x"></i> Address</h3>
            <p>{{$user->address}}</p>
        </div>
        @endif
        @if($user->phone)
        <div class="contact-phone contact-side-desc contact-box-desc">
            <h3><i class="fa fa-phone cl-atlantis fa-2x"></i> Phone</h3>
            <p>{{$user->phone}}</p>
        </div>
        @endif
        <div class="contact-mail contact-side-desc contact-box-desc">
            <h3><i class="fa fa-envelope-o cl-atlantis fa-2x"></i> Email</h3>
        <address class="address-details-f">
            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
        </address>
        <ul class="list-inline social-icon-f top-data">
            @if($user->phone)
            <li>
                <a href="https://wa.me/{{ $user->phone }}?text=Hello%20I%20want%20to%20contact%20you" target="_blank">
                    <i class="fa top-social fa-whatsapp"></i>
                </a>
            </li>
            @endif
            @if($user->linkedIn_url)
            <li>
                <a href="{{$user->linkedIn_url}}" target="_blank">
                    <i class="fa top-social fa-linkedin"></i>
                </a>
            </li>
            @endif
            @if($user->email)
            <li>
                <a href="mailto:{{ $user->email }}">
                    <i class="fa top-social fa-envelope"></i>
                </a>
            </li>
            @endif
        </ul>
        </div>
        </div>
    </div>
    </div>
</section>

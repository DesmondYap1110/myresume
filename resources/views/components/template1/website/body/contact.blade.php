<section class="resume-section p-3 p-lg-5 d-flex flex-column">
    <div class="row my-auto" id="contact">
    <div class="col-md-8">
        <div class="contact-cont">
        <h3>CONTACT Us</h3>
        </div>
        <div class="row con-form">
        <div class="col-md-12">
            <input type="text" name="full-name" placeholder="Full Name" class="form-control">
        </div>
        <div class="col-md-12">
            <input type="text" name="email" placeholder="Email Id" class="form-control">
        </div>
        <div class="col-md-12">
            <input type="text" name="subject" placeholder="Subject" class="form-control">
        </div>
        <div class="col-md-12"><textarea name="" id=""></textarea></div>
        <div class="col-md-12 sub-but"><button class="btn btn-general btn-white" role="button">Send</button></div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mt-5">
        <div class="contact-cont2">
        <div class="contact-add contact-box-desc">
            <h3><i class="fa fa-map-marker cl-atlantis fa-2x"></i> Address</h3>
            <p>{{$user->address}}</p>
        </div>
        <div class="contact-phone contact-side-desc contact-box-desc">
            <h3><i class="fa fa-phone cl-atlantis fa-2x"></i> Phone</h3>
            <p>{{$user->phone}}</p>
        </div>
        <div class="contact-mail contact-side-desc contact-box-desc">
            <h3><i class="fa fa-envelope-o cl-atlantis fa-2x"></i> Email</h3>
        <address class="address-details-f">
            Email: <a href="mailto:{{$user->email}}" class="">{{$user->email}}</a>
        </address>
        <ul class="list-inline social-icon-f top-data">
            <li>
                <a href="https://wa.me/{{ $user->phone }}?text=Hello%20I%20want%20to%20contact%20you" target="_blank">
                    <i class="fa top-social fa-whatsapp" style="color: #25D366; border-color:#25D366;"></i>
                </a>
            </li>

            <li>
                <a href="{{$user->linkedIn_url}}" target="_blank">
                    <i class="fa top-social fa-linkedin" style="color: #0077b5; border-color:#0077b5;"></i>
                </a>
            </li>

            <li>
                <a href="mailto:{{ $user->email }}">
                    <i class="fa top-social fa-envelope" style="color: #D44638; border-color:#D44638;"></i>
                </a>
            </li>
        </ul>
        </div>
        </div>
    </div>
    </div>
</section>

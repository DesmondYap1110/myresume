<section class="resume-section p-3 p-lg-5 d-flex flex-column">
    <div class="row my-auto" id="contact">
    <div class="col-md-8">
        <div class="contact-cont">
        <h3>CONTACT Us</h3>
        </div>
        <form action="<?php echo e(route('front.contact',request()->id)); ?>" method="post">
        <?php echo csrf_field(); ?>
            <div class="row con-form">

                    <div class="col-md-12">
                        <input type="text" name="name" placeholder="Full Name" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="email" placeholder="Email Id" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <input type="text" name="subject" placeholder="Subject" class="form-control">
                    </div>
                    <div class="col-md-12"><textarea name="description" ></textarea></div>
                    <div class="col-md-12 sub-but"><button class="btn btn-general btn-white" type="submit">Send</button></div>

            </div>
        </form>
    </div>
    <div class="col-md-4 col-sm-12 mt-5">
        <div class="contact-cont2">
        <?php if($user->address): ?>
        <div class="contact-add contact-box-desc">
            <h3><i class="fa fa-map-marker cl-atlantis fa-2x"></i> Address</h3>
            <p><?php echo e($user->address); ?></p>
        </div>
        <?php endif; ?>
        <?php if($user->phone): ?>
        <div class="contact-phone contact-side-desc contact-box-desc">
            <h3><i class="fa fa-phone cl-atlantis fa-2x"></i> Phone</h3>
            <p><?php echo e($user->phone); ?></p>
        </div>
        <?php endif; ?>
        <div class="contact-mail contact-side-desc contact-box-desc">
            <h3><i class="fa fa-envelope-o cl-atlantis fa-2x"></i> Email</h3>
        <address class="address-details-f">
            Email: <a href="mailto:<?php echo e($user->email); ?>" class=""><?php echo e($user->email); ?></a>
        </address>
        <ul class="list-inline social-icon-f top-data">
            <?php if($user->phone): ?>
            <li>
                <a href="https://wa.me/<?php echo e($user->phone); ?>?text=Hello%20I%20want%20to%20contact%20you" target="_blank">
                    <i class="fa top-social fa-whatsapp" style="color: #25D366; border-color:#25D366;"></i>
                </a>
            </li>
            <?php endif; ?>
            <?php if($user->linkedIn_url): ?>
            <li>
                <a href="<?php echo e($user->linkedIn_url); ?>" target="_blank">
                    <i class="fa top-social fa-linkedin" style="color: #0077b5; border-color:#0077b5;"></i>
                </a>
            </li>
            <?php endif; ?>
            <?php if($user->email): ?>
            <li>
                <a href="mailto:<?php echo e($user->email); ?>">
                    <i class="fa top-social fa-envelope" style="color: #D44638; border-color:#D44638;"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
        </div>
        </div>
    </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\SAPPM\resources\views/components/template1/website/body/contact.blade.php ENDPATH**/ ?>
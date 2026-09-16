<?php
    $id = request()->id;

    // Admin descriptions are rich-text HTML. Show list items as a clean list
    // and everything else as plain text, all escaped.
    $bullets = function ($html) {
        preg_match_all('#<li[^>]*>(.*?)</li>#is', (string) $html, $m);
        $items = array_values(array_filter(array_map(fn ($i) => trim(html_entity_decode(strip_tags($i))), $m[1])));
        return $items;
    };
    $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags(str_replace(['</p>', '</li>', '<br>', '<br/>', '<br />'], ' ', (string) $html)))));

    $period = fn ($start, $end) => \App\Support\Period::label($start, $end);

    // Short titles only: the headline is one line.
    $roles = \App\Support\RoleLabel::headlineWords($experience, $user->role) ?: ['Web Developer'];

    $about = $plain($user->about);
    $firstName = trim(explode(' ', trim((string) $user->name))[0] ?? $user->name);

    // Menu shows only the sections that have content.
    $sections = collect([
        'about' => 'About',
        'experience' => count($experience) ? 'Experience' : null,
        'education' => count($education) ? 'Education' : null,
        'projects' => count($project) ? 'Projects' : null,
        'services' => count($service) ? 'Services' : null,
        'reviews' => count($testimonial) ? 'Reviews' : null,
        'blog' => count($blog) ? 'Blog' : null,
        'contact' => 'Contact',
    ])->filter()->all();
?>

<?php $__env->startPush('t2-scripts'); ?>
<?php if(session('success') || $errors->any()): ?>
<script>
    // Bring the visitor back to the contact form to see the result.
    document.getElementById('contact') && document.getElementById('contact').scrollIntoView();
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginal508270d59867368494d21ca6c3d30618 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal508270d59867368494d21ca6c3d30618 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template2.website.master.master-layout','data' => ['user' => $user,'blog' => $blog,'sections' => $sections]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template2.website.master.master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'blog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($blog),'sections' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sections)]); ?>

    
    <section class="section banner t2-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <p class="t2-kicker" data-aos="fade-up">Hello, I'm <?php echo e($firstName); ?></p>
                    <h1 class="cd-headline clip is-full-width mb-4" data-aos="fade-up" data-aos-delay="100">
                        I work as a <br>
                        <span class="cd-words-wrapper text-color">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <b class="<?php echo e($i === 0 ? 'is-visible' : ''); ?>"><?php echo e($role); ?>.</b>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </span>
                    </h1>
                    <?php if($about): ?>
                    <p class="t2-lead" data-aos="fade-up" data-aos-delay="200"><?php echo e(\Illuminate\Support\Str::limit($about, 220)); ?></p>
                    <?php endif; ?>
                    <div class="mt-5" data-aos="fade-up" data-aos-delay="300">
                        <a href="#contact" class="btn btn-main mr-2 mb-2">Contact me</a>
                        <?php if(count($blog)): ?>
                        <a href="#blog" class="btn btn-black mb-2">Read my blog</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if($user->image): ?>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
                    <div class="t2-portrait">
                        <span class="t2-portrait-orb" aria-hidden="true"></span>
                        <span class="t2-portrait-frame" aria-hidden="true"></span>
                        <span class="t2-portrait-dots" aria-hidden="true"></span>
                        <img src="<?php echo e($user->image); ?>" alt="<?php echo e($user->name); ?>" class="img-fluid">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="section banner-3 border-top" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7" data-aos="fade-up">
                    <h2 class="mb-2"><?php echo e($user->name); ?></h2>
                    <?php if($user->role): ?>
                    <p class="lead mb-4"><?php echo e($user->role); ?></p>
                    <?php endif; ?>
                    <?php if($about): ?>
                    <p class="mb-4"><?php echo e($about); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="150">
                    <ul class="list-unstyled mt-3 mb-5 about-list t2-facts">
                        <?php if($user->address): ?>
                        <li><i class="ti-location-pin"></i> <?php echo e($user->address); ?></li>
                        <?php endif; ?>
                        <?php if($user->email): ?>
                        <li><i class="ti-email"></i> <a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></li>
                        <?php endif; ?>
                        <?php if($user->phone): ?>
                        <li><i class="ti-mobile"></i> <a href="https://wa.me/<?php echo e($user->phone); ?>" target="_blank" rel="noopener">+<?php echo e($user->phone); ?></a></li>
                        <?php endif; ?>
                        <?php if($user->linkedIn_url): ?>
                        <li><i class="ti-linkedin"></i> <a href="<?php echo e($user->linkedIn_url); ?>" target="_blank" rel="noopener">LinkedIn profile</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    
    <?php if(count($experience)): ?>
    <section class="section about border-top" id="experience">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <h3 class="mb-2">Work Experiences.</h3>
                </div>
                <div class="col-lg-8">
                    <?php $__currentLoopData = $experience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $items = $bullets($job->detail); ?>
                    <div class="about-info t2-timeline mb-5" data-aos="fade-up">
                        <span><?php echo e($period($job->start_date, $job->end_date)); ?></span>
                        <h4 class="mb-3 mt-1"><?php echo e($job->role); ?> <span class="text-color">at</span> <?php echo e($job->company); ?></h4>
                        <?php if($items): ?>
                        <ul class="t2-bullets">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($item); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php else: ?>
                        <p><?php echo e($plain($job->detail)); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($education)): ?>
    <section class="section about border-top" id="education">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <h3 class="mb-2">Education.</h3>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-6">
                            <div class="about-info mb-5" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                                <?php if($edu->year): ?><span><?php echo e($edu->year); ?></span><?php endif; ?>
                                <h4 class="mb-2 mt-1"><?php echo e($edu->institution); ?></h4>
                                <p class="mb-1 text-dark"><?php echo e($edu->certificate); ?></p>
                                <p><?php echo e($plain($edu->achievement)); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($project)): ?>
    <section class="section service-home border-top" id="projects">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">Projects.</h2>
                    <p class="mb-5">Selected work I have delivered.</p>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $project; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item mb-5" data-aos="fade-left" data-aos-delay="<?php echo e($loop->index * 150); ?>">
                        <i class="ti-layout"></i>
                        <h4 class="my-3"><?php echo e($item->name); ?></h4>
                        <p class="text-sm mb-2 text-color"><?php echo e($item->company); ?> · <?php echo e($period($item->start_date, $item->end_date)); ?></p>
                        <p><?php echo e(\Illuminate\Support\Str::limit($plain($item->detail), 160)); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($service)): ?>
    <section class="section service-home border-top" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">Services.</h2>
                    <p class="mb-5">What I can help you with.</p>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item mb-5" data-aos="fade-left" data-aos-delay="<?php echo e($loop->index * 150); ?>">
                        <i class="<?php echo e($item->iconSet()['ti']); ?>"></i>
                        <h4 class="my-3"><?php echo e($item->title); ?></h4>
                        <p><?php echo e($item->description); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($testimonial)): ?>
    <section class="section border-top t2-reviews" id="reviews">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">What clients say.</h2>
                    <p class="mb-5">Feedback from the people I have worked with.</p>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $testimonial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6">
                    <blockquote class="t2-review mb-4" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                        <div class="t2-stars" aria-label="<?php echo e($review->rating); ?> out of 5 stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="ti-star <?php echo e($i <= $review->rating ? 'is-on' : ''); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="t2-review-text">"<?php echo e($review->message); ?>"</p>
                        <footer class="t2-review-by">
                            <?php if($review->image): ?>
                            <img src="<?php echo e($review->image); ?>" alt="<?php echo e($review->name); ?>">
                            <?php else: ?>
                            <span class="t2-review-initials"><?php echo e($review->initials()); ?></span>
                            <?php endif; ?>
                            <span>
                                <b><?php echo e($review->name); ?></b>
                                <?php if($review->position): ?><small><?php echo e($review->position); ?></small><?php endif; ?>
                            </span>
                        </footer>
                    </blockquote>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if(count($blog)): ?>
    <section class="section blog-post border-top" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">Latest Blog.</h2>
                    <p class="mb-5">Notes on the projects I build.</p>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $cover = optional($post->images->first())->url ?: $post->image;
                    $url = route('front.post', [$post->id, $id]);
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="post mb-5" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                        <a class="image-content t2-post-image" href="<?php echo e($url); ?>">
                            <img src="<?php echo e($cover); ?>" alt="<?php echo e($post->title); ?>" class="img-fluid">
                            <?php if($post->images->count() > 1): ?>
                            <span class="t2-count"><i class="ti-gallery"></i> <?php echo e($post->images->count()); ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="post-content">
                            <span class="date text-uppercase text-sm"><?php echo e($post->created_at->format('d M Y')); ?></span>
                            <a href="<?php echo e($url); ?>"><h4><?php echo e($post->title); ?></h4></a>
                            <p class="text-sm mb-3"><?php echo e(\Illuminate\Support\Str::limit($plain($post->description), 120)); ?></p>
                            <a href="<?php echo e($url); ?>" class="t2-more">Read more <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="section-sm pt-0 cta">
        <div class="container">
            <div class="row align-items-center t2-cta p-5" data-aos="zoom-in">
                <div class="col-lg-8">
                    <h3 class="text-white mb-0">Want to discuss a project?</h3>
                </div>
                <div class="col-lg-4 text-lg-right mt-4 mt-lg-0">
                    <a href="#contact" class="btn btn-white">Contact me</a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="contact section border-top" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 col-md-4">
                    <h4>Contact Info</h4>
                    <p>Have a question or an opportunity? Send me a message and I'll get back to you.</p>
                </div>
                <div class="col-lg-4 mb-4 col-md-4">
                    <h4>Location</h4>
                    <p><?php echo e($user->address ?: '-'); ?></p>
                </div>
                <div class="col-lg-4 mb-4 col-md-4">
                    <h4>Contact</h4>
                    <?php if($user->email): ?><p class="mb-0"><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></p><?php endif; ?>
                    <?php if($user->phone): ?><p class="mb-0">+<?php echo e($user->phone); ?></p><?php endif; ?>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4 mt-5 contact-title">
                        <h2>Get in touch</h2>
                    </div>

                    <?php if(session('success')): ?>
                    <div class="alert alert-success" role="alert">Thank you! Your message has been sent.</div>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($error); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>

                    <form class="contact__form mt-4" method="post" action="<?php echo e(route('front.contact', $id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginalbefff79ebe02d15a63d58a8c62261865 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbefff79ebe02d15a63d58a8c62261865 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.website.form-guard','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('website.form-guard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbefff79ebe02d15a63d58a8c62261865)): ?>
<?php $attributes = $__attributesOriginalbefff79ebe02d15a63d58a8c62261865; ?>
<?php unset($__attributesOriginalbefff79ebe02d15a63d58a8c62261865); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbefff79ebe02d15a63d58a8c62261865)): ?>
<?php $component = $__componentOriginalbefff79ebe02d15a63d58a8c62261865; ?>
<?php unset($__componentOriginalbefff79ebe02d15a63d58a8c62261865); ?>
<?php endif; ?>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name" value="<?php echo e(old('name')); ?>" required maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <input name="subject" type="text" class="form-control" placeholder="Subject" value="<?php echo e(old('subject')); ?>" maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <input name="email" type="email" class="form-control" placeholder="Email Address" value="<?php echo e(old('email')); ?>" required maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group-2 mb-4">
                                    <textarea name="description" class="form-control" rows="6" placeholder="Your Message" required maxlength="5000"><?php echo e(old('description')); ?></textarea>
                                </div>
                                <div class="form-group mb-4 t2-captcha">
                                    <?php if (isset($component)) { $__componentOriginal46a9c03d8a6c39c2c5a36bfe00743b69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal46a9c03d8a6c39c2c5a36bfe00743b69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.website.captcha','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('website.captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal46a9c03d8a6c39c2c5a36bfe00743b69)): ?>
<?php $attributes = $__attributesOriginal46a9c03d8a6c39c2c5a36bfe00743b69; ?>
<?php unset($__attributesOriginal46a9c03d8a6c39c2c5a36bfe00743b69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46a9c03d8a6c39c2c5a36bfe00743b69)): ?>
<?php $component = $__componentOriginal46a9c03d8a6c39c2c5a36bfe00743b69; ?>
<?php unset($__componentOriginal46a9c03d8a6c39c2c5a36bfe00743b69); ?>
<?php endif; ?>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-main" type="submit">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal508270d59867368494d21ca6c3d30618)): ?>
<?php $attributes = $__attributesOriginal508270d59867368494d21ca6c3d30618; ?>
<?php unset($__attributesOriginal508270d59867368494d21ca6c3d30618); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal508270d59867368494d21ca6c3d30618)): ?>
<?php $component = $__componentOriginal508270d59867368494d21ca6c3d30618; ?>
<?php unset($__componentOriginal508270d59867368494d21ca6c3d30618); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\myresume\resources\views/website/template2/index.blade.php ENDPATH**/ ?>
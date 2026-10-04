@php
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
    $roles = \App\Support\RoleLabel::headlineWords($experience, $user->t('role')) ?: ['Web Developer'];

    $about = $plain($user->t('about'));
    $firstName = trim(explode(' ', trim((string) $user->name))[0] ?? $user->name);

    // Menu shows only the sections that have content.
    $sections = collect([
        'about' => __('site.nav.about'),
        'experience' => count($experience) ? __('site.nav.experience') : null,
        'education' => count($education) ? __('site.nav.education') : null,
        'projects' => count($project) ? __('site.nav.projects') : null,
        'skills' => count($skill) ? __('site.nav.skills') : null,
        'services' => count($service) ? __('site.nav.services') : null,
        'reviews' => count($testimonial) ? __('site.nav.testimonials') : null,
        'blog' => count($blog) ? __('site.nav.blog') : null,
        'contact' => __('site.nav.contact'),
    ])->filter()->all();
@endphp

@push('t2-scripts')
@if(session('success') || $errors->any())
<script>
    // Bring the visitor back to the contact form to see the result.
    document.getElementById('contact') && document.getElementById('contact').scrollIntoView();
</script>
@endif
<script>
// The rotating job title is clipped when it is wider than the banner. Measure
// how much is hidden and let the CSS slide the word across to show its end.
(function () {
    var wrapper = document.querySelector('.t2-banner .cd-words-wrapper');
    if (!wrapper) return;

    var pending = null;

    function fit() {
        wrapper.querySelectorAll('b').forEach(function (word) {
            var visible = word.classList.contains('is-visible');
            var hidden = visible ? word.offsetWidth - wrapper.clientWidth : 0;

            if (visible && hidden > 2) {
                word.style.setProperty('--t2-pan', '-' + (hidden + 4) + 'px');
                word.classList.add('is-panning');
            } else {
                word.classList.remove('is-panning');
                word.style.removeProperty('--t2-pan');
            }
        });
    }

    // The plugin swaps .is-visible and animates the wrapper width over 600ms,
    // so measure once that has settled.
    function schedule() {
        clearTimeout(pending);
        pending = setTimeout(fit, 700);
    }

    new MutationObserver(schedule).observe(wrapper, {
        attributes: true,
        attributeFilter: ['class', 'style'],
        subtree: true
    });

    window.addEventListener('resize', schedule);
    schedule();
})();
</script>
@endpush

<x-template2.website.master.master-layout :user="$user" :blog="$blog" :sections="$sections">

    {{-- ============ Banner ============ --}}
    <section class="section banner t2-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <p class="t2-kicker" data-aos="fade-up">{{ __('site.ui.hello_im', ['name' => $firstName]) }}</p>
                    <h1 class="cd-headline clip is-full-width mb-4" data-aos="fade-up" data-aos-delay="100">
                        {{ __('site.ui.i_work_as') }} <br>
                        <span class="cd-words-wrapper text-color">
                            @foreach($roles as $i => $role)
                            <b class="{{ $i === 0 ? 'is-visible' : '' }}">{{ $role }}.</b>
                            @endforeach
                        </span>
                    </h1>
                    @if($about)
                    <p class="t2-lead" data-aos="fade-up" data-aos-delay="200">{{ $about }}</p>
                    @endif
                    <div class="mt-5 t2-actions" data-aos="fade-up" data-aos-delay="300">
                        <a href="#contact" class="btn btn-main mr-2 mb-2">{{ __('site.action.contact_me') }}</a>
                        @if($user->hasResume())
                        <a href="{{ $user->resumeUrl() }}" class="btn btn-black mr-2 mb-2"><i class="ti-download mr-1" aria-hidden="true"></i> {{ __('site.action.download_resume') }}</a>
                        @endif
                        @if(count($blog))
                        <a href="#blog" class="btn btn-black mb-2">{{ __('site.action.read_my_blog') }}</a>
                        @endif
                    </div>
                </div>
                @if($user->image)
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
                    <div class="t2-portrait">
                        <span class="t2-portrait-orb" aria-hidden="true"></span>
                        <span class="t2-portrait-frame" aria-hidden="true"></span>
                        <span class="t2-portrait-dots" aria-hidden="true"></span>
                        <img src="{{ $user->image }}" alt="{{ $user->name }}" class="img-fluid">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ About ============ --}}
    <section class="section banner-3 border-top" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-7" data-aos="fade-up">
                    <h2 class="mb-2">{{ $user->name }}</h2>
                    @if($user->t('role'))
                    <p class="lead mb-4">{{ $user->t('role') }}</p>
                    @endif
                    {{-- The about text is already in full in the banner above. --}}
                </div>
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="150">
                    <ul class="list-unstyled mt-3 mb-5 about-list t2-facts">
                        @if($user->address)
                        <li><i class="ti-location-pin"></i> {{ $user->address }}</li>
                        @endif
                        @if($user->email)
                        <li><i class="ti-email"></i> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                        @endif
                        @if($user->phone)
                        <li><i class="ti-mobile"></i> <a href="https://wa.me/{{ $user->phone }}" target="_blank" rel="noopener">+{{ $user->phone }}</a></li>
                        @endif
                    </ul>

                    {{-- One line of icons rather than a row each: the list is
                         as long as the number of networks, and the labels add
                         nothing the icon does not already say. --}}
                    @if(count($user->socialLinks()))
                    <ul class="list-inline t2-social-row mb-5">
                        @foreach($user->socialLinks() as $link)
                        <li class="list-inline-item">
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener me"
                               title="{{ $link['label'] }}" aria-label="{{ $link['label'] }}">
                                <x-social-icon :network="$link" :size="18" />
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ============ Experience ============ --}}
    @if(count($experience))
    <section class="section about border-top" id="experience">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <h3 class="mb-2">{{ __('site.section.experience') }}</h3>
                </div>
                <div class="col-lg-8">
                    @foreach($experience as $job)
                    @php $items = $bullets($job->t('detail')); @endphp
                    <div class="about-info t2-timeline mb-5" data-aos="fade-up">
                        <span>{{ $period($job->start_date, $job->end_date) }}</span>
                        <h4 class="mb-3 mt-1">{{ $job->t('role') }} <span class="text-color">at</span> {{ $job->t('company') }}</h4>
                        @if($items)
                        <ul class="t2-bullets">
                            @foreach($items as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        @else
                        <p>{{ $plain($job->t('detail')) }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============ Education ============ --}}
    @if(count($education))
    <section class="section about border-top" id="education">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <h3 class="mb-2">{{ __('site.section.education') }}</h3>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($education as $edu)
                        <div class="col-lg-6">
                            <div class="about-info mb-5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                @if($edu->year)<span>{{ $edu->year }}</span>@endif
                                <h4 class="mb-2 mt-1">{{ $edu->t('institution') }}</h4>
                                <p class="mb-1 text-dark">{{ $edu->t('certificate') }}</p>
                                <p>{{ $plain($edu->t('achievement')) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============ Projects ============ --}}
    @if(count($project))
    <section class="section service-home border-top" id="projects">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">{{ __('site.section.projects') }}</h2>
                    <p class="mb-5">{{ __('site.more.selected_work_note') }}</p>
                </div>
            </div>
            <div class="row">
                @foreach($project as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="service-item mb-5" data-aos="fade-left" data-aos-delay="{{ $loop->index * 150 }}">
                        <i class="ti-layout"></i>
                        <h4 class="my-3">{{ $item->t('name') }}</h4>
                        <p class="text-sm mb-2 text-color">{{ $item->t('company') }} · {{ $period($item->start_date, $item->end_date) }}</p>
                        <p>{{ \Illuminate\Support\Str::limit($plain($item->t('detail')), 160) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ Skills ============ --}}
    @if(count($skill))
    <section class="section border-top" id="skills">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-5">{{ __('site.section.skills') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12" data-aos="fade-left">
                    <ul class="t2-skill-tags">
                        @foreach($skill as $item)
                        <li>{{ $item->t('name') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============ Services ============ --}}
    @if(count($service))
    <section class="section service-home border-top" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">{{ __('site.section.services') }}</h2>
                    <p class="mb-5">{{ __('site.more.what_i_help') }}</p>
                </div>
            </div>
            <div class="row">
                @foreach($service as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="service-item mb-5" data-aos="fade-left" data-aos-delay="{{ $loop->index * 150 }}">
                        <i class="{{ $item->iconSet()['ti'] }}"></i>
                        <h4 class="my-3">{{ $item->t('title') }}</h4>
                        <p>{{ $item->t('description') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ Testimonials ============ --}}
    @if(count($testimonial))
    <section class="section border-top t2-reviews" id="reviews">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">{{ __('site.section.what_clients_say') }}</h2>
                    <p class="mb-5">Feedback from the people I have worked with.</p>
                </div>
            </div>
            <div class="row">
                @foreach($testimonial as $review)
                <div class="col-lg-4 col-md-6">
                    <blockquote class="t2-review mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="t2-stars" aria-label="{{ $review->rating }} out of 5 stars">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="ti-star {{ $i <= $review->rating ? 'is-on' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="t2-review-text">"{{ $review->t('message') }}"</p>
                        <footer class="t2-review-by">
                            @if($review->image)
                            <img src="{{ $review->image }}" alt="{{ $review->name }}">
                            @else
                            <span class="t2-review-initials">{{ $review->initials() }}</span>
                            @endif
                            <span>
                                <b>{{ $review->name }}</b>
                                @if($review->t('position'))<small>{{ $review->t('position') }}</small>@endif
                            </span>
                        </footer>
                    </blockquote>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ Blog ============ --}}
    @if(count($blog))
    <section class="section blog-post border-top" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-2">{{ __('site.more.latest_blog') }}</h2>
                    <p class="mb-5">{{ __('site.more.projects_note') }}</p>
                </div>
            </div>
            <div class="row">
                @foreach($blog as $post)
                @php
                    $cover = optional($post->images->first())->url ?: $post->image;
                    $url = route('front.post', [$post->id, $id]);
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="post mb-5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <a class="image-content t2-post-image" href="{{ $url }}">
                            <img src="{{ $cover }}" alt="{{ $post->t('title') }}" class="img-fluid">
                            @if($post->images->count() > 1)
                            <span class="t2-count"><i class="ti-gallery"></i> {{ $post->images->count() }}</span>
                            @endif
                        </a>
                        <div class="post-content">
                            <span class="date text-uppercase text-sm">{{ $post->created_at->format('d M Y') }}</span>
                            <a href="{{ $url }}"><h4>{{ $post->t('title') }}</h4></a>
                            <p class="text-sm mb-3">{{ \Illuminate\Support\Str::limit($plain($post->t('description')), 120) }}</p>
                            <a href="{{ $url }}" class="t2-more">Read more <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============ CTA ============ --}}
    <section class="section-sm pt-0 cta">
        <div class="container">
            <div class="row align-items-center t2-cta p-5" data-aos="zoom-in">
                <div class="col-lg-8">
                    <h3 class="text-white mb-0">{{ __('site.more.discuss_project') }}</h3>
                </div>
                <div class="col-lg-4 text-lg-right mt-4 mt-lg-0">
                    <a href="#contact" class="btn btn-white">{{ __('site.action.contact_me') }}</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ Contact ============ --}}
    <section class="contact section border-top" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 col-md-4">
                    <h4>{{ __('site.label.contact_info') }}</h4>
                    <p>Have a question or an opportunity? Send me a message and I'll get back to you.</p>
                </div>
                <div class="col-lg-4 mb-4 col-md-4">
                    <h4>{{ __('site.label.location') }}</h4>
                    <p>{{ $user->address ?: '-' }}</p>
                </div>
                <div class="col-lg-4 mb-4 col-md-4">
                    <h4>{{ __('site.section.contact') }}</h4>
                    @if($user->email)<p class="mb-0"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>@endif
                    @if($user->phone)<p class="mb-0">+{{ $user->phone }}</p>@endif
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4 mt-5 contact-title">
                        <h2>{{ __('site.section.get_in_touch') }}</h2>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success" role="alert">{{ __('site.form.sent') }}</div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                    @endif

                    <form class="contact__form mt-4" method="post" action="{{ route('front.contact', $id) }}">
                        @csrf
                        <x-website.form-guard />
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <input name="name" type="text" class="form-control" placeholder="{{ __('site.ui.your_name') }}" value="{{ old('name') }}" required maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <input name="subject" type="text" class="form-control" placeholder="{{ __('site.ui.subject') }}" value="{{ old('subject') }}" maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <input name="email" type="email" class="form-control" placeholder="{{ __('site.ui.email_address') }}" value="{{ old('email') }}" required maxlength="255">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group-2 mb-4">
                                    <textarea name="description" class="form-control" rows="6" placeholder="{{ __('site.ui.your_message') }}" required maxlength="5000">{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group mb-4 t2-captcha">
                                    <x-website.captcha />
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-main" type="submit">{{ __('site.action.send_message') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-template2.website.master.master-layout>

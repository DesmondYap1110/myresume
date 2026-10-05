@php
    $key = $user->routeKey();

    // Admin editors store HTML; this template shows plain text and bullet lists.
    $bullets = function ($html) {
        preg_match_all('#<li[^>]*>(.*?)</li>#is', (string) $html, $m);
        return array_values(array_filter(array_map(fn ($i) => trim(html_entity_decode(strip_tags($i))), $m[1])));
    };
    $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags(str_replace(['</p>', '</li>', '<br>', '<br/>', '<br />'], ' ', (string) $html)))));
    $period = fn ($start, $end) => \App\Support\Period::label($start, $end);

    $about = $plain($user->t('about'));
    $age = null;
    try { $age = $user->dob ? \Carbon\Carbon::parse($user->dob)->age : null; } catch (\Throwable $e) {}

    // Only sections with content appear, in the menu and on the page.
    $sections = collect([
        'about' => __('site.nav.about'),
        'skills' => count($skill) ? __('site.nav.skills') : null,
        'services' => count($service) ? __('site.nav.services') : null,
        'portfolio' => count($blog) ? __('site.nav.blog') : null,
        'projects' => count($project) ? __('site.nav.projects') : null,
        'experience' => count($experience) ? __('site.nav.experience') : null,
        'education' => count($education) ? __('site.nav.education') : null,
        'references' => count($testimonial) ? __('site.nav.testimonials') : null,
        'contact' => __('site.nav.contact'),
    ])->filter()->all();

    $initials = collect(preg_split('/\s+/', trim((string) $user->name)))->filter()->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    $whatsapp = $user->phone ? 'https://wa.me/'.preg_replace('/\D+/', '', $user->phone) : null;

    // Short titles the hero types through, current role first.
    $roles = \App\Support\RoleLabel::headlineWords($experience, $user->t('role')) ?: array_filter([$user->t('role')]);

    // Numbers for the count-up band; only the ones that are above zero show.
    $firstStart = collect($experience)->pluck('start_date')->filter()->sort()->first();
    $years = $firstStart ? max(1, (int) date('Y') - (int) substr($firstStart, 0, 4)) : 0;
    $stats = array_filter([
        ['value' => $years, 'suffix' => '+', 'label' => 'Years experience', 'icon' => 'fa-briefcase'],
        ['value' => collect($experience)->pluck('company')->map(fn ($c) => \Illuminate\Support\Str::lower(trim(preg_replace('/\(.*?\)/', '', (string) $c))))->filter()->unique()->count(), 'suffix' => '', 'label' => 'Companies', 'icon' => 'fa-building'],
        ['value' => count($blog) + count($project), 'suffix' => '', 'label' => 'Projects shipped', 'icon' => 'fa-rocket'],
        ['value' => count($testimonial), 'suffix' => '', 'label' => 'Happy clients', 'icon' => 'fa-smile-o'],
    ], fn ($s) => $s['value'] > 0);
@endphp

<x-template4.website.master.master-layout :user="$user" :sections="$sections">

  {{-- ═══ PROFILE ═══ --}}
  <div class="profile-page">
    <div class="wrapper">
      <div class="page-header page-header-small" filter-color="green">
        {{-- The parallax script moves this layer; the slow zoom runs on the one inside it. --}}
        <div class="page-header-image" data-parallax="true">
          <div class="t4-hero-bg" style="background-image: url('{{ asset('assets/website/template4/img/banner.jpg') }}')"></div>
        </div>
        <div class="t4-orbs" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>
        <div class="container">
          <div class="content-center t4-hero-in">
            <div class="cc-profile-image">
              <a href="#about">
                @if($user->image)
                  <img src="{{ $user->image }}" alt="{{ $user->name }}">
                @else
                  <span class="cc-profile-initials" aria-hidden="true">{{ $initials }}</span>
                @endif
              </a>
            </div>
            <h1 class="h2 title">{{ $user->name }}</h1>
            @if($user->t('role'))
            {{-- Shows the role as-is; with motion allowed it types through the roles below. --}}
            <p class="category text-white t4-typed" data-roles='@json($roles)'><span class="t4-typed-text">{{ $user->t('role') }}</span><span class="t4-caret" aria-hidden="true"></span></p>
            @endif
            <div class="t4-hero-actions">
              <a class="btn btn-primary smooth-scroll mr-2" href="#contact">{{ __('site.action.hire_me') }}</a>
              @if($user->hasResume())
              <a class="btn btn-primary" href="{{ $user->resumeUrl() }}"><i class="fa fa-download mr-1" aria-hidden="true"></i> {{ __('site.action.download_resume') }}</a>
              @endif
            </div>
          </div>
        </div>
        <div class="section">
          <div class="container">
            <div class="button-container">
              @foreach($user->socialLinks() as $link)
              <a class="btn btn-default btn-round btn-icon t4-social" href="{{ $link['url'] }}" target="_blank" rel="noopener me" title="{{ $link['label'] }}" aria-label="{{ $link['label'] }}"><x-social-icon :network="$link" :size="17" tone="current" /></a>
              @endforeach
              {{-- WhatsApp is one of the Social Links rows now, so it is not
                   repeated here; only email stays, as it has no row. --}}
              @if($user->email)
              <a class="btn btn-default btn-round btn-icon t4-social" href="mailto:{{ $user->email }}" title="{{ __('site.more.email_me') }}" aria-label="{{ __('site.label.email') }}"><i class="fa fa-envelope"></i></a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ═══ ABOUT ═══ --}}
  <div class="section" id="about">
    <div class="container">
      <div class="card" data-aos="fade-up" data-aos-offset="10">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="card-body t4-about">
              <div class="h4 mt-0 title">{{ __('site.section.about') }}</div>
              @if($about)
                <p>{{ $about }}</p>
              @else
                <p class="text-muted">{{ $user->t('role') ?: 'Profile coming soon.' }}</p>
              @endif
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="card-body t4-info">
              <div class="h4 mt-0 title">{{ __('site.more.basic_info') }}</div>
              @if($age)
              <div class="row"><div class="col-sm-4"><strong class="text-uppercase">Age:</strong></div><div class="col-sm-8">{{ $age }}</div></div>
              @endif
              @if($user->t('role'))
              <div class="row"><div class="col-sm-4"><strong class="text-uppercase">Role:</strong></div><div class="col-sm-8">{{ $user->t('role') }}</div></div>
              @endif
              @if($user->email)
              <div class="row"><div class="col-sm-4"><strong class="text-uppercase">Email:</strong></div><div class="col-sm-8"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div></div>
              @endif
              @if($user->phone)
              <div class="row"><div class="col-sm-4"><strong class="text-uppercase">Phone:</strong></div><div class="col-sm-8">{{ $user->phone }}</div></div>
              @endif
              @if($user->address)
              <div class="row"><div class="col-sm-4"><strong class="text-uppercase">Address:</strong></div><div class="col-sm-8">{{ $user->address }}</div></div>
              @endif
              @if($user->hasResume())
              <div class="row"><div class="col-sm-4"><strong class="text-uppercase">Resume:</strong></div><div class="col-sm-8"><a href="{{ $user->resumeUrl() }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> {{ __('site.action.download_resume') }}</a></div></div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ═══ STATS (count up when scrolled into view) ═══ --}}
  @if(count($stats))
  <div class="t4-stats">
    <div class="container">
      <div class="row justify-content-center">
        @foreach($stats as $stat)
        <div class="col-6 col-md-3">
          <div class="t4-stat" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
            <i class="fa {{ $stat['icon'] }}" aria-hidden="true"></i>
            {{-- The real number is in the markup; the animation only replays it. --}}
            <span class="t4-stat-num"><span class="t4-count" data-count="{{ $stat['value'] }}">{{ $stat['value'] }}</span>{{ $stat['suffix'] }}</span>
            <span class="t4-stat-label">{{ $stat['label'] }}</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  {{-- ═══ SKILLS (the one template that shows the level) ═══ --}}
  @if(count($skill))
  <div class="section" id="skills">
    <div class="container">
      <div class="h4 text-center mb-4 title">{{ __('site.section.skills') }}</div>
      <div class="row justify-content-center">
        @foreach($skill->chunk(ceil(count($skill) / 2)) as $column)
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          @foreach($column as $item)
          <div class="t4-skill">
            <div class="t4-skill-head">
              <span>{{ $item->t('name') }}</span>
              <span class="t4-skill-pct">{{ $item->level }}%</span>
            </div>
            <div class="t4-skill-track">
              <span class="t4-skill-fill" style="width: {{ $item->level }}%"></span>
            </div>
          </div>
          @endforeach
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  {{-- ═══ SERVICES (where the old site had skill bars) ═══ --}}
  @if(count($service))
  <div class="section" id="services">
    <div class="container">
      <div class="h4 text-center mb-4 title">{{ __('site.more.what_i_do') }}</div>
      <div class="row justify-content-center">
        @foreach($service as $item)
        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
          <div class="card t4-service mb-0">
            <div class="t4-icon"><i class="fa {{ $item->iconSet()['fa4'] }}" aria-hidden="true"></i></div>
            <div class="h5 mt-0">{{ $item->t('title') }}</div>
            <div class="svc-rich">{!! $item->t('description') !!}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  {{-- ═══ PORTFOLIO (blog posts, with the template's hover caption) ═══ --}}
  @if(count($blog))
  <div class="section" id="portfolio">
    <div class="container">
      <div class="h4 text-center mb-4 title">{{ __('site.more.portfolio') }}</div>
      <div class="gallery mt-5">
        <div class="row justify-content-center">
          @foreach($blog as $post)
          @php $cover = optional($post->imagesFor()->first())->url ?: $post->image; @endphp
          <div class="col-md-6">
            <div class="cc-porfolio-image img-raised" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
              <a href="{{ route('front.post', [$post->id, $key]) }}">
                <figure class="cc-effect">
                  <img src="{{ $cover }}" alt="{{ $post->t('title') }}" loading="lazy">
                  <figcaption>
                    <div class="h4">{{ \Illuminate\Support\Str::limit($post->t('title'), 70) }}</div>
                    <p>{{ \Illuminate\Support\Str::limit($plain($post->t('description')), 110) }}</p>
                  </figcaption>
                </figure>
                <span class="t4-folio-label">{{ $post->t('title') }}<small>{{ $post->created_at->format('d M Y') }}@if($post->imagesFor()->count() > 1) · {{ $post->imagesFor()->count() }} images @endif</small></span>
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- ═══ PROJECTS ═══ --}}
  @if(count($project))
  <div class="section" id="projects">
    <div class="container cc-experience">
      <div class="h4 text-center mb-4 title">{{ __('site.section.projects') }}</div>
      @foreach($project as $item)
      <div class="card">
        <div class="row">
          <div class="col-lg-3 col-md-4 bg-primary" data-aos="fade-right" data-aos-offset="50" data-aos-duration="500">
            <div class="card-body cc-experience-header">
              <p>{{ $period($item->start_date, $item->end_date) }}</p>
              <div class="h5">{{ $item->t('company') }}</div>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 t4-detail" data-aos="fade-left" data-aos-offset="50" data-aos-duration="500">
            <div class="card-body">
              <div class="h5">{{ $item->t('name') }}</div>
              <p class="mb-0">{{ $plain($item->t('detail')) }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- ═══ EXPERIENCE ═══ --}}
  @if(count($experience))
  <div class="section" id="experience">
    <div class="container cc-experience">
      <div class="h4 text-center mb-4 title">{{ __('site.section.experience') }}</div>
      @foreach($experience as $job)
      @php $items = $bullets($job->t('detail')); @endphp
      <div class="card">
        <div class="row">
          <div class="col-lg-3 col-md-4 bg-primary" data-aos="fade-right" data-aos-offset="50" data-aos-duration="500">
            <div class="card-body cc-experience-header">
              <p>{{ $period($job->start_date, $job->end_date) }}</p>
              <div class="h5">{{ $job->t('company') }}</div>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 t4-detail" data-aos="fade-left" data-aos-offset="50" data-aos-duration="500">
            <div class="card-body">
              <div class="h5">{{ $job->t('role') }}</div>
              @if($items)
              <ul class="t4-bullets">
                @foreach($items as $line)<li>{{ $line }}</li>@endforeach
              </ul>
              @else
              <p class="mb-0">{{ $plain($job->t('detail')) }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- ═══ EDUCATION ═══ --}}
  @if(count($education))
  <div class="section" id="education">
    <div class="container cc-education">
      <div class="h4 text-center mb-4 title">{{ __('site.section.education') }}</div>
      @foreach($education as $edu)
      <div class="card">
        <div class="row">
          <div class="col-lg-3 col-md-4 bg-primary" data-aos="fade-right" data-aos-offset="50" data-aos-duration="500">
            <div class="card-body cc-education-header">
              @if($edu->year)<p>{{ $edu->year }}</p>@endif
              <div class="h5">{{ $edu->t('institution') }}</div>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 t4-detail" data-aos="fade-left" data-aos-offset="50" data-aos-duration="500">
            <div class="card-body">
              <div class="h5">{{ $edu->t('certificate') }}</div>
              @if($plain($edu->t('achievement')))<p class="category mt-2 mb-0">{{ $plain($edu->t('achievement')) }}</p>@endif
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- ═══ REFERENCES (testimonials) ═══ --}}
  @if(count($testimonial))
  <div class="section" id="references">
    <div class="container cc-reference">
      <div class="h4 mb-4 text-center title">{{ __('site.more.references') }}</div>
      <div class="card" data-aos="zoom-in">
        <div class="carousel slide" id="cc-Indicators" data-ride="carousel" data-interval="7000">
          @if(count($testimonial) > 1)
          <ol class="carousel-indicators">
            @foreach($testimonial as $review)
            <li class="{{ $loop->first ? 'active' : '' }}" data-target="#cc-Indicators" data-slide-to="{{ $loop->index }}"></li>
            @endforeach
          </ol>
          @endif
          <div class="carousel-inner">
            @foreach($testimonial as $review)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
              <div class="row">
                <div class="col-lg-3 col-md-4 cc-reference-header text-center">
                  @if($review->image)
                    <img class="t4-avatar" src="{{ $review->image }}" alt="{{ $review->name }}" loading="lazy">
                  @else
                    <span class="t4-avatar-initials" aria-hidden="true">{{ $review->initials() }}</span>
                  @endif
                  <div class="h5 pt-2">{{ $review->name }}</div>
                  @if($review->t('position'))<p class="category">{{ $review->t('position') }}</p>@endif
                </div>
                <div class="col-lg-9 col-md-8">
                  <div class="t4-stars" aria-label="{{ $review->rating }} out of 5 stars">
                    @for($i = 1; $i <= 5; $i++)<i class="fa fa-star {{ $i <= $review->rating ? '' : 'off' }}" aria-hidden="true"></i>@endfor
                  </div>
                  <p>{{ $review->t('message') }}</p>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- ═══ CONTACT ═══ --}}
  <div class="section" id="contact">
    <div class="cc-contact-information">
      <div class="container">
        <div class="cc-contact">
          <div class="row">
            <div class="col-md-9">
              <div class="card mb-0" data-aos="zoom-in">
                <div class="h4 text-center title">{{ __('site.action.contact_me') }}</div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body">
                      @if(session('success'))
                      <div class="alert alert-success" role="alert">{{ __('site.form.sent') }}</div>
                      @endif
                      @if($errors->any())
                      <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                      </div>
                      @endif

                      <form action="{{ route('front.contact', $key) }}" method="POST">
                        @csrf
                        <x-website.form-guard />
                        <div class="p pb-3"><strong>{{ __('site.more.feel_free') }}</strong></div>
                        <div class="row mb-3">
                          <div class="col">
                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                              <input class="form-control" type="text" name="name" placeholder="{{ __('site.ui.name') }}" value="{{ old('name') }}" required maxlength="255" autocomplete="name">
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                              <input class="form-control" type="email" name="email" placeholder="{{ __('site.ui.e_mail') }}" value="{{ old('email') }}" required maxlength="255" autocomplete="email">
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <div class="input-group"><span class="input-group-addon"><i class="fa fa-file-text"></i></span>
                              <input class="form-control" type="text" name="subject" placeholder="{{ __('site.ui.subject') }}" value="{{ old('subject') }}" maxlength="255">
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <div class="form-group mb-0">
                              <textarea class="form-control" name="description" placeholder="{{ __('site.ui.your_message') }}" required maxlength="5000">{{ old('description') }}</textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <div class="col captcha-field"><x-website.captcha /></div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <button class="btn btn-primary" type="submit">{{ __('site.more.send') }}</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card-body">
                      @if($user->phone)
                      <p class="mb-0"><strong>{{ __('site.label.phone') }}</strong></p>
                      <p class="pb-2">{{ $user->phone }}</p>
                      @endif
                      @if($user->email)
                      <p class="mb-0"><strong>{{ __('site.label.email') }}</strong></p>
                      <p class="pb-2"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                      @endif
                      @if($user->address)
                      <p class="mb-0"><strong>{{ __('site.label.location') }}</strong></p>
                      <p class="pb-2">{{ $user->address }}</p>
                      @endif
                      @if($user->hasResume())
                      <a class="btn btn-primary btn-round mt-2" href="{{ $user->resumeUrl() }}"><i class="fa fa-download mr-1" aria-hidden="true"></i> {{ __('site.action.download_resume') }}</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</x-template4.website.master.master-layout>

@php
    $key = $user->routeKey();
    $home = route('front.show', $key);
    $images = $post->imagesFor()->pluck('url')->filter()->values();
    if ($images->isEmpty() && $post->image) $images = collect([$post->image]);

    $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) $post->t('description'))));
    $minutes = max(1, (int) round(str_word_count($text) / 200));
    $others = $blog->where('id', '!=', $post->id)->take(2);

    // Translated, so the menu on a post page matches the rest of the site.
    $sections = ['about' => __('site.section.about'), 'portfolio' => __('site.nav.blog'), 'contact' => __('site.section.contact')];
@endphp

<x-template4.website.master.master-layout :user="$user" :home="$home" :sections="$sections" :post="$post">

  <div class="profile-page">
    <div class="wrapper">
      <div class="page-header page-header-small" filter-color="green">
        <div class="page-header-image" data-parallax="true">
          <div class="t4-hero-bg" style="background-image: url('{{ $images->first() ?: asset('assets/website/template4/img/banner.jpg') }}')"></div>
        </div>
        <div class="t4-orbs" aria-hidden="true"><span></span><span></span><span></span></div>
        <div class="container">
          <div class="content-center t4-hero-in">
            <p class="category text-white mb-2">{{ __('site.more.portfolio') }}</p>
            <h1 class="h2 title">{{ $post->t('title') }}</h1>
            <p class="text-white mb-0">{{ $post->created_at->format('d F Y') }} · {{ $minutes }} min read · {{ $user->name }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <a href="{{ $home }}#portfolio" class="d-inline-block mb-4"><i class="fa fa-arrow-left mr-1" aria-hidden="true"></i> Back to portfolio</a>

          <div class="card">
            @if($images->count())
            <div class="carousel slide t4-post-carousel" id="post-images" data-ride="carousel" data-interval="false">
              @if($images->count() > 1)
              <ol class="carousel-indicators">
                @foreach($images as $image)
                <li class="{{ $loop->first ? 'active' : '' }}" data-target="#post-images" data-slide-to="{{ $loop->index }}"></li>
                @endforeach
              </ol>
              @endif
              <div class="carousel-inner">
                @foreach($images as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                  <img src="{{ $image }}" alt="{{ $post->t('title') }} - image {{ $loop->iteration }}" @if(!$loop->first) loading="lazy" @endif>
                </div>
                @endforeach
              </div>
              @if($images->count() > 1)
              <a class="carousel-control-prev" href="#post-images" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">{{ __('site.more.previous_image') }}</span></a>
              <a class="carousel-control-next" href="#post-images" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">{{ __('site.more.next_image') }}</span></a>
              @endif
            </div>
            @endif

            <div class="card-body p-4 p-md-5">
              {{-- Written by the site owner in the admin editor. --}}
              <div class="t4-post-body">{!! $post->t('description') !!}</div>
              <x-website.media-embeds :blog="$post" />

              @php $shareUrl = urlencode(url()->current()); @endphp
              <hr class="my-4">
              <div class="d-flex flex-wrap align-items-center">
                <span class="mr-3 text-muted">Share:</span>
                <a class="btn btn-link px-2" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="{{ __('site.more.share_linkedin') }}"><i class="fa fa-linkedin fa-lg"></i></a>
                <a class="btn btn-link px-2" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="{{ __('site.more.share_facebook') }}"><i class="fa fa-facebook fa-lg"></i></a>
                <a class="btn btn-link px-2" href="https://wa.me/?text={{ urlencode($post->t('title').' '.url()->current()) }}" target="_blank" rel="noopener" aria-label="{{ __('site.more.share_whatsapp') }}"><i class="fa fa-whatsapp fa-lg"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($others->count())
  <div class="section pt-0">
    <div class="container">
      <div class="h4 text-center mb-4 title">{{ __('site.more.more_work') }}</div>
      <div class="gallery">
        <div class="row justify-content-center">
          @foreach($others as $other)
          <div class="col-md-6 col-lg-5">
            <div class="cc-porfolio-image img-raised">
              <a href="{{ route('front.post', [$other->id, $key]) }}">
                <figure class="cc-effect">
                  <img src="{{ optional($other->images->first())->url ?: $other->image }}" alt="{{ $other->t('title') }}" loading="lazy">
                  <figcaption><div class="h4">{{ \Illuminate\Support\Str::limit($other->t('title'), 70) }}</div></figcaption>
                </figure>
                <span class="t4-folio-label">{{ $other->t('title') }}<small>{{ $other->created_at->format('d M Y') }}</small></span>
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif

</x-template4.website.master.master-layout>

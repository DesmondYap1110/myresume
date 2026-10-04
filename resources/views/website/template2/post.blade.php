@php
    $id = request()->id;
    $home = route('front.show', $id);
    $images = $post->imagesFor()->pluck('url')->filter()->values();
    if ($images->isEmpty() && $post->image) $images = collect([$post->image]);

    $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) $post->t('description'))));
    $minutes = max(1, (int) round(str_word_count($text) / 200));
    $shareUrl = urlencode(url()->current());
    $others = $blog->where('id', '!=', $post->id)->take(4);
@endphp

<x-template2.website.master.master-layout :user="$user" :title="$post->t('title')" :home="$home" :blog="$blog" :post="$post">

    <section class="page-title section pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ $home }}#blog" class="t2-back"><i class="ti-arrow-left"></i> Back to blog</a>
                        <h1 class="mb-0 t2-post-title">{{ $post->t('title') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section blog-post">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="single-post">
                        @if($images->count() > 1)
                        <div class="owl-carousel owl-theme t2-gallery" aria-label="{{ __('site.more.images') }}">
                            @foreach($images as $image)
                            <a href="{{ $image }}" target="_blank" rel="noopener"><img src="{{ $image }}" alt="{{ $post->t('title') }} - image {{ $loop->iteration }}" class="img-fluid"></a>
                            @endforeach
                        </div>
                        @elseif($images->count() === 1)
                        <a href="{{ $images->first() }}" target="_blank" rel="noopener"><img src="{{ $images->first() }}" alt="{{ $post->t('title') }}" class="img-fluid t2-single-image"></a>
                        @endif

                        <div class="single-post-content mt-4">
                            <div class="post-meta mb-4">
                                <span class="text-black">By</span> <span>{{ $user->name }}</span>
                                <span class="ml-3">-</span>
                                <span class="date">{{ $post->created_at->format('d F Y') }}</span>
                                <span class="ml-3">-</span>
                                <span>{{ $minutes }} min read</span>
                            </div>

                            {{-- Written by the site owner in the admin editor. --}}
                            <div class="t2-content">{!! $post->t('description') !!}</div>

                            <div class="share mt-5">
                                <ul class="list-inline">
                                    <li class="mb-3">Share Now :</li>
                                    <li class="list-inline-item"><a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener"><i class="ti-linkedin mr-2"></i> LinkedIn</a></li>
                                    <li class="list-inline-item"><a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"><i class="ti-facebook mr-2"></i> Facebook</a></li>
                                    <li class="list-inline-item"><a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ urlencode($post->t('title')) }}" target="_blank" rel="noopener"><i class="ti-twitter mr-2"></i> Twitter</a></li>
                                    <li class="list-inline-item"><a href="https://wa.me/?text={{ urlencode($post->t('title').' '.url()->current()) }}" target="_blank" rel="noopener"><i class="ti-mobile mr-2"></i> WhatsApp</a></li>
                                </ul>
                            </div>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-widget mt-5 mt-lg-0">
                        <div class="widget mb-5 t2-author">
                            <h4 class="mb-4 widget-title">{{ __('site.more.about_author') }}</h4>
                            <div class="d-flex align-items-center mb-3">
                                @if($user->image)
                                <img src="{{ $user->image }}" alt="{{ $user->name }}" class="mr-3">
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    @if($user->t('role'))<span class="text-sm">{{ $user->t('role') }}</span>@endif
                                </div>
                            </div>
                            <p class="text-sm">{{ \Illuminate\Support\Str::limit(strip_tags((string) $user->t('about')), 160) }}</p>
                            <a href="{{ $home }}#contact" class="btn btn-main btn-sm">{{ __('site.action.contact_me') }}</a>
                        </div>

                        @if($others->count())
                        <div class="widget mb-5">
                            <h4 class="mb-4 widget-title">{{ __('site.more.more_posts') }}</h4>
                            <ul class="list-unstyled">
                                @foreach($others as $other)
                                <li class="d-flex mb-4">
                                    <a href="{{ route('front.post', [$other->id, $id]) }}" class="t2-thumb mr-3">
                                        <img src="{{ optional($other->images->first())->url ?: $other->image }}" alt="" class="img-fluid">
                                    </a>
                                    <div class="post-body">
                                        <span class="text-capitalize">{{ $other->created_at->format('d M Y') }}</span>
                                        <a href="{{ route('front.post', [$other->id, $id]) }}"><h5>{{ $other->t('title') }}</h5></a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="widget mb-5 follow">
                            <h4 class="mb-4 widget-title">{{ __('site.more.follow_me') }}</h4>
                            <ul class="list-inline">
                                @if($user->linkedIn_url)<li class="list-inline-item"><a href="{{ $user->linkedIn_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="ti-linkedin"></i></a></li>@endif
                                @if($user->email)<li class="list-inline-item"><a href="mailto:{{ $user->email }}" aria-label="{{ __('site.label.email') }}"><i class="ti-email"></i></a></li>@endif
                                @if($user->phone)<li class="list-inline-item"><a href="https://wa.me/{{ $user->phone }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="ti-mobile"></i></a></li>@endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-template2.website.master.master-layout>

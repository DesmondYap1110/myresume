@php
    $id = request()->id;
    $home = route('front.show', $id);
    $images = $post->imagesFor()->pluck('url')->filter()->values();
    if ($images->isEmpty() && $post->image) $images = collect([$post->image]);

    $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) $post->t('description'))));
    $minutes = max(1, (int) round(str_word_count($text) / 200));
    $others = $blog->where('id', '!=', $post->id)->take(3);
@endphp

<x-template3.website.master.master-layout :user="$user" :title="$post->t('title')" :home="$home" :blog="$blog" :post="$post">

    <article class="pt-32 pb-24">
        <div class="max-w-3xl mx-auto px-6">
            <a href="{{ $home }}#blog" class="nl inline-flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400 hover:text-accent-ink dark:hover:text-accent transition-colors mb-8">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('site.more.back_to_blog') }}
            </a>

            <p class="text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">{{ __('site.section.blog') }}</p>
            <h1 class="font-display font-bold text-3xl md:text-4xl leading-tight tracking-tight text-zinc-900 dark:text-white mb-4">{{ $post->t('title') }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-10">{{ $post->created_at->format('d F Y') }} · {{ $minutes }} min read · {{ $user->name }}</p>

            @if($images->count())
            <div x-data="{ i: 0, total: {{ $images->count() }} }" class="mb-10">
                <div class="pf rounded-2xl aspect-[4/5] sm:aspect-[4/3] relative">
                    @foreach($images as $image)
                    <img src="{{ $image }}" alt="{{ $post->t('title') }} - image {{ $loop->iteration }}" x-show="i === {{ $loop->index }}" x-transition.opacity class="absolute inset-0 w-full h-full object-contain bg-zinc-100 dark:bg-zinc-900" @if(!$loop->first) x-cloak @endif>
                    @endforeach

                    @if($images->count() > 1)
                    <button @click="i = (i - 1 + total) % total" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 dark:bg-zinc-900/90 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center hover:border-accent transition-colors" aria-label="{{ __('site.more.previous_image') }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="i = (i + 1) % total" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 dark:bg-zinc-900/90 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center hover:border-accent transition-colors" aria-label="{{ __('site.more.next_image') }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @endif
                </div>

                @if($images->count() > 1)
                <div class="flex gap-2 mt-4">
                    @foreach($images as $image)
                    <button @click="i = {{ $loop->index }}" class="pf w-16 h-16 rounded-lg border-2 transition-colors" :class="i === {{ $loop->index }} ? 'border-accent' : 'border-transparent opacity-60 hover:opacity-100'" aria-label="{{ __('site.more.show_image', ['number' => $loop->iteration]) }}">
                        <img src="{{ $image }}" alt="" loading="lazy">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            {{-- Written by the site owner in the admin editor. --}}
            <div class="rich text-zinc-600 dark:text-zinc-400 leading-relaxed">{!! $post->t('description') !!}</div>
            <x-website.media-embeds :blog="$post" />

            <div class="mt-12 pt-8 border-t border-zinc-100 dark:border-zinc-900 flex flex-wrap items-center gap-4">
                <span class="text-sm text-zinc-500 dark:text-zinc-400">Share:</span>
                @php $shareUrl = urlencode(url()->current()); @endphp
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener" class="nl text-sm text-zinc-600 dark:text-zinc-400 hover:text-accent-ink dark:hover:text-accent transition-colors">LinkedIn</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" class="nl text-sm text-zinc-600 dark:text-zinc-400 hover:text-accent-ink dark:hover:text-accent transition-colors">Facebook</a>
                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ urlencode($post->t('title')) }}" target="_blank" rel="noopener" class="nl text-sm text-zinc-600 dark:text-zinc-400 hover:text-accent-ink dark:hover:text-accent transition-colors">Twitter</a>
                <a href="https://wa.me/?text={{ urlencode($post->t('title').' '.url()->current()) }}" target="_blank" rel="noopener" class="nl text-sm text-zinc-600 dark:text-zinc-400 hover:text-accent-ink dark:hover:text-accent transition-colors">WhatsApp</a>
            </div>
        </div>
    </article>

    @if($others->count())
    <section class="py-20 bg-zinc-50 dark:bg-zinc-900/40">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="font-display font-bold text-2xl text-zinc-900 dark:text-white mb-8">{{ __('site.more.more_posts') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($others as $other)
                <article class="card-h group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden border border-zinc-100 dark:border-zinc-800 hover:border-accent">
                    <a href="{{ route('front.post', [$other->id, $id]) }}" class="block">
                        <div class="pf aspect-[4/3]">
                            <img src="{{ optional($other->images->first())->url ?: $other->image }}" alt="" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">{{ $other->created_at->format('d M Y') }}</p>
                            <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white leading-snug group-hover:text-accent-ink dark:group-hover:text-accent transition-colors">{{ $other->t('title') }}</h3>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-template3.website.master.master-layout>

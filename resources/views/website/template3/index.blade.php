@php
    $id = request()->id;

    $bullets = function ($html) {
        preg_match_all('#<li[^>]*>(.*?)</li>#is', (string) $html, $m);
        return array_values(array_filter(array_map(fn ($i) => trim(html_entity_decode(strip_tags($i))), $m[1])));
    };
    $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags(str_replace(['</p>', '</li>', '<br>', '<br/>', '<br />'], ' ', (string) $html)))));

    $period = fn ($start, $end) => \App\Support\Period::label($start, $end, true);

    $about = $plain($user->about);
    $firstName = trim(explode(' ', trim((string) $user->name))[0] ?? $user->name);

    // Only show sections that have content.
    $sections = collect([
        'services' => count($service) ? 'Services' : null,
        'work' => count($project) ? 'Work' : null,
        'about' => 'About',
        'reviews' => count($testimonial) ? 'Reviews' : null,
        'blog' => count($blog) ? 'Blog' : null,
        'contact' => 'Contact',
    ])->filter()->all();

    // Years of experience from the earliest job start.
    $firstStart = collect($experience)->pluck('start_date')->filter()->sort()->first();
    $firstYear = $firstStart ? (int) substr($firstStart, 0, 4) : null;
    $years = $firstYear ? max(1, (int) date('Y') - $firstYear) : null;
@endphp

<x-template3.website.master.master-layout :user="$user" :blog="$blog" :sections="$sections">

    {{-- ═══ HERO ═══ --}}
    <section id="hero" class="relative min-h-screen flex items-center pt-16 overflow-hidden">
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute bottom-1/4 left-0 w-64 h-64 bg-zinc-200/50 dark:bg-zinc-800/30 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-6 py-24 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="reveal text-sm font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-4">Available for work</p>
                    <h1 class="reveal d1 font-display font-bold text-5xl md:text-6xl lg:text-7xl leading-[1.05] tracking-tight text-zinc-900 dark:text-white mb-6">
                        Hi, I'm <span class="text-accent-ink dark:text-accent">{{ $firstName }}</span>
                    </h1>
                    @if($about)
                    <p class="reveal d2 text-lg md:text-xl text-zinc-500 dark:text-zinc-400 font-light leading-relaxed max-w-md mb-10">
                        @if($user->role)<strong class="font-medium text-zinc-700 dark:text-zinc-300">{{ $user->role }}</strong>. @endif
                        {{ \Illuminate\Support\Str::limit($about, 180) }}
                    </p>
                    @endif

                    <div class="reveal d3 flex flex-wrap gap-4">
                        @if(count($project))
                        <a href="#work" class="shimmer inline-flex items-center gap-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-medium px-7 py-3.5 rounded-full hover:bg-zinc-700 dark:hover:bg-zinc-200 transition-colors text-sm">
                            View my work
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                        @endif
                        <a href="#contact" class="inline-flex items-center gap-2 border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 font-medium px-7 py-3.5 rounded-full hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-colors text-sm">Get in touch</a>
                    </div>

                    <div class="reveal d4 flex gap-8 mt-14 pt-8 border-t border-zinc-100 dark:border-zinc-900">
                        @if(count($project))
                        <div><p class="font-display font-bold text-3xl text-zinc-900 dark:text-white">{{ count($project) }}</p><p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Projects</p></div>
                        @endif
                        @if($years)
                        <div><p class="font-display font-bold text-3xl text-zinc-900 dark:text-white">{{ $years }}y</p><p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Experience</p></div>
                        @endif
                        @if(count($testimonial))
                        <div><p class="font-display font-bold text-3xl text-zinc-900 dark:text-white">{{ count($testimonial) }}</p><p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Happy clients</p></div>
                        @endif
                    </div>
                </div>

                @if($user->image)
                <div class="reveal d2 flex justify-center md:justify-end">
                    <div class="relative w-72 h-72 md:w-80 md:h-80 lg:w-96 lg:h-96">
                        <div class="pf w-full h-full rounded-3xl">
                            <img src="{{ $user->image }}" alt="{{ $user->name }}" loading="eager">
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-accent text-zinc-900 font-display font-bold text-sm px-4 py-2.5 rounded-2xl shadow-lg">Open to projects</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ SERVICES ═══ --}}
    @if(count($service))
    <section id="services" class="py-24 bg-zinc-50 dark:bg-zinc-900/40">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-14">
                <p class="reveal text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">What I do</p>
                <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">Services</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($service as $item)
                @php $dark = $loop->index % 3 === 1; @endphp
                <article class="reveal d{{ min($loop->iteration, 4) }} card-h group rounded-2xl p-8 border hover:border-accent {{ $dark ? 'bg-zinc-900 dark:bg-zinc-800 border-zinc-800' : 'bg-white dark:bg-zinc-900 border-zinc-100 dark:border-zinc-800' }}">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl mb-6 transition-colors {{ $dark ? 'bg-zinc-800 dark:bg-zinc-700 group-hover:bg-accent/20' : 'bg-accent/10 group-hover:bg-accent/20' }}">
                        <svg class="w-6 h-6 {{ $dark ? 'text-accent' : 'text-accent-ink dark:text-accent' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item->iconSet()['svg'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-bold text-xl mb-3 {{ $dark ? 'text-white' : 'text-zinc-900 dark:text-white' }}">{{ $item->title }}</h3>
                    <p class="text-sm leading-relaxed {{ $dark ? 'text-zinc-400' : 'text-zinc-500 dark:text-zinc-400' }}">{{ $item->description }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ WORK ═══ --}}
    @if(count($project))
    <section id="work" class="py-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-14">
                <p class="reveal text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">Portfolio</p>
                <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">Selected work</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($project as $item)
                <article class="reveal d{{ min($loop->iteration, 4) }} card-h bg-zinc-50 dark:bg-zinc-900 rounded-2xl p-8 border border-zinc-100 dark:border-zinc-800 hover:border-accent">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">{{ $period($item->start_date, $item->end_date) }}</p>
                    <h3 class="font-display font-bold text-2xl text-zinc-900 dark:text-white mb-1">{{ $item->name }}</h3>
                    <p class="text-sm text-accent-ink dark:text-accent mb-4">{{ $item->company }}</p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ $plain($item->detail) }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ ABOUT (experience + education) ═══ --}}
    <section id="about" class="py-24 bg-zinc-50 dark:bg-zinc-900/40">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-14">
                <p class="reveal text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">About me</p>
                <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">{{ $user->name }}</h2>
                @if($about)
                <p class="reveal d2 text-zinc-500 dark:text-zinc-400 leading-relaxed max-w-3xl mt-6">{{ $about }}</p>
                @endif
            </div>

            @if(count($experience))
            <h3 class="reveal font-display font-bold text-2xl text-zinc-900 dark:text-white mb-8">Experience</h3>
            <div class="space-y-4 mb-16">
                @foreach($experience as $job)
                @php $items = $bullets($job->detail); @endphp
                <article class="reveal card-h bg-white dark:bg-zinc-900 rounded-2xl p-7 border border-zinc-100 dark:border-zinc-800 hover:border-accent">
                    <div class="flex flex-wrap items-baseline justify-between gap-2 mb-3">
                        <h4 class="font-display font-bold text-lg text-zinc-900 dark:text-white">{{ $job->role }} <span class="text-accent-ink dark:text-accent">at</span> {{ $job->company }}</h4>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $period($job->start_date, $job->end_date) }}</span>
                    </div>
                    @if($items)
                    <ul class="space-y-2">
                        @foreach($items as $line)
                        <li class="flex gap-3 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-accent shrink-0" aria-hidden="true"></span>{{ $line }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ $plain($job->detail) }}</p>
                    @endif
                </article>
                @endforeach
            </div>
            @endif

            @if(count($education))
            <h3 class="reveal font-display font-bold text-2xl text-zinc-900 dark:text-white mb-8">Education</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($education as $edu)
                <article class="reveal card-h bg-white dark:bg-zinc-900 rounded-2xl p-7 border border-zinc-100 dark:border-zinc-800 hover:border-accent">
                    @if($edu->year)<span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $edu->year }}</span>@endif
                    <h4 class="font-display font-bold text-lg text-zinc-900 dark:text-white mt-1">{{ $edu->institution }}</h4>
                    <p class="text-sm text-accent-ink dark:text-accent mb-2">{{ $edu->certificate }}</p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $plain($edu->achievement) }}</p>
                </article>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ REVIEWS ═══ --}}
    @if(count($testimonial))
    <section id="reviews" class="py-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-14">
                <p class="reveal text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">Social proof</p>
                <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">What clients say</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($testimonial as $review)
                @php $dark = $loop->index % 3 === 1; @endphp
                <blockquote class="reveal d{{ min($loop->iteration, 4) }} rounded-2xl p-7 border {{ $dark ? 'bg-zinc-900 dark:bg-zinc-800 border-zinc-800' : 'bg-zinc-50 dark:bg-zinc-900 border-zinc-100 dark:border-zinc-800' }}">
                    <div class="flex gap-0.5 mb-5" aria-label="{{ $review->rating }} out of 5 stars">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 fill-current {{ $i <= $review->rating ? 'text-accent' : 'text-zinc-300 dark:text-zinc-700' }}" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>

                    <p class="text-sm leading-relaxed mb-6 italic {{ $dark ? 'text-zinc-400' : 'text-zinc-600 dark:text-zinc-400' }}">"{{ $review->message }}"</p>

                    <footer class="flex items-center gap-3">
                        @if($review->image)
                        <div class="pf w-10 h-10 rounded-full shrink-0"><img src="{{ $review->image }}" alt="{{ $review->name }}" loading="lazy"></div>
                        @else
                        <span class="w-10 h-10 rounded-full shrink-0 bg-accent text-zinc-900 font-medium text-sm flex items-center justify-center" aria-hidden="true">{{ $review->initials() }}</span>
                        @endif
                        <div>
                            <p class="font-medium text-sm {{ $dark ? 'text-white' : 'text-zinc-900 dark:text-white' }}">{{ $review->name }}</p>
                            @if($review->position)<p class="text-xs text-zinc-500">{{ $review->position }}</p>@endif
                        </div>
                    </footer>
                </blockquote>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ BLOG ═══ --}}
    @if(count($blog))
    <section id="blog" class="py-24 bg-zinc-50 dark:bg-zinc-900/40">
        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-14">
                <p class="reveal text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">Thoughts</p>
                <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white">From the blog</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($blog as $post)
                @php
                    $cover = optional($post->images->first())->url ?: $post->image;
                    $url = route('front.post', [$post->id, $id]);
                @endphp
                <article class="reveal d{{ min($loop->iteration, 4) }} card-h group bg-white dark:bg-zinc-900 rounded-2xl overflow-hidden border border-zinc-100 dark:border-zinc-800 hover:border-accent">
                    <a href="{{ $url }}" class="block">
                        <div class="pf aspect-[4/3] relative">
                            <img src="{{ $cover }}" alt="{{ $post->title }}" loading="lazy" class="group-hover:scale-105 transition-transform duration-500">
                            @if($post->images->count() > 1)
                            <span class="absolute top-3 right-3 bg-accent text-zinc-900 text-xs font-medium px-2 py-1 rounded-full">{{ $post->images->count() }} images</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">{{ $post->created_at->format('d M Y') }}</p>
                            <h3 class="font-display font-bold text-lg text-zinc-900 dark:text-white leading-snug mb-3 group-hover:text-accent-ink dark:group-hover:text-accent transition-colors">{{ $post->title }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ \Illuminate\Support\Str::limit($plain($post->description), 110) }}</p>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ CONTACT ═══ --}}
    <section id="contact" class="py-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <p class="reveal text-xs font-medium text-accent-ink dark:text-accent tracking-widest uppercase mb-3">Contact</p>
                    <h2 class="reveal d1 font-display font-bold text-4xl md:text-5xl text-zinc-900 dark:text-white mb-6">Let's work together</h2>
                    <p class="reveal d2 text-zinc-500 dark:text-zinc-400 leading-relaxed mb-8">Have a question or a project in mind? Send me a message and I'll get back to you.</p>

                    <ul class="reveal d3 space-y-3 text-sm">
                        @if($user->email)<li><a href="mailto:{{ $user->email }}" class="text-zinc-700 dark:text-zinc-300 hover:text-accent-ink dark:hover:text-accent transition-colors">{{ $user->email }}</a></li>@endif
                        @if($user->phone)<li><a href="https://wa.me/{{ $user->phone }}" target="_blank" rel="noopener" class="text-zinc-700 dark:text-zinc-300 hover:text-accent-ink dark:hover:text-accent transition-colors">+{{ $user->phone }}</a></li>@endif
                        @if($user->address)<li class="text-zinc-500 dark:text-zinc-400">{{ $user->address }}</li>@endif
                    </ul>
                </div>

                <div class="reveal d2">
                    @if(session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-900 px-4 py-3 text-sm text-green-700 dark:text-green-300">Thank you! Your message has been sent.</div>
                    @endif
                    @if($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-900 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                    @endif

                    <form method="post" action="{{ route('front.contact', $id) }}" class="space-y-4">
                        @csrf
                        <x-website.form-guard />
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="fname" class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1.5">Name</label>
                                <input type="text" id="fname" name="name" required maxlength="255" value="{{ old('name') }}" autocomplete="name"
                                       class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-3 text-sm focus:border-accent focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label for="femail" class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1.5">Email</label>
                                <input type="email" id="femail" name="email" required maxlength="255" value="{{ old('email') }}" autocomplete="email"
                                       class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-3 text-sm focus:border-accent focus:outline-none transition-colors">
                            </div>
                        </div>
                        <div>
                            <label for="fsubject" class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1.5">Subject</label>
                            <input type="text" id="fsubject" name="subject" maxlength="255" value="{{ old('subject') }}"
                                   class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-3 text-sm focus:border-accent focus:outline-none transition-colors">
                        </div>
                        <div>
                            <label for="fmessage" class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1.5">Message</label>
                            <textarea id="fmessage" name="description" rows="5" required maxlength="5000"
                                      class="w-full rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 py-3 text-sm focus:border-accent focus:outline-none transition-colors">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="shimmer w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-medium px-8 py-3.5 rounded-full hover:bg-zinc-700 dark:hover:bg-zinc-200 transition-colors text-sm">
                            Send message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-template3.website.master.master-layout>

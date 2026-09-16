<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null]); ?>
<?php foreach (array_filter((['user', 'title' => null, 'home' => '', 'blog' => [], 'sections' => [], 'post' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    $branding = \App\Support\Branding::websiteColors($user, 'template3');
    $accent = $branding['accent'] ?? '#FF6B2B';
    // Bright accents (gold, mint) need darkening to stay readable on white.
    $accentInk = \App\Support\Branding::darken($accent, 32);
    $accentLight = $branding['accent'] ?? '#FF8F5C';
    $first = trim(explode(' ', trim((string) $user->name))[0] ?? '');
    $links = $sections ?: ['services' => 'Services', 'work' => 'Work', 'about' => 'About', 'reviews' => 'Reviews', 'blog' => 'Blog', 'contact' => 'Contact'];
?>
<!DOCTYPE html>
<html lang="en" x-data="folio()" :class="{'dark': dark}" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if (isset($component)) { $__componentOriginalddf8eec87a3172e652805bac126d7ed0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalddf8eec87a3172e652805bac126d7ed0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.website.seo','data' => ['user' => $user,'post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('website.seo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalddf8eec87a3172e652805bac126d7ed0)): ?>
<?php $attributes = $__attributesOriginalddf8eec87a3172e652805bac126d7ed0; ?>
<?php unset($__attributesOriginalddf8eec87a3172e652805bac126d7ed0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalddf8eec87a3172e652805bac126d7ed0)): ?>
<?php $component = $__componentOriginalddf8eec87a3172e652805bac126d7ed0; ?>
<?php unset($__componentOriginalddf8eec87a3172e652805bac126d7ed0); ?>
<?php endif; ?>
<link rel="icon" href="<?php echo e(asset('assets/admin/img/kaiadmin/favicon.ico')); ?>" type="image/x-icon">

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: { display: ['PT Sans','sans-serif'], body: ['DM Sans','sans-serif'] },
      // Colours come from Theme Setting in the back office.
      colors: {
        accent: '<?php echo e($accent); ?>',
        'accent-light': '<?php echo e($accentLight); ?>',
        'accent-ink': '<?php echo e($accentInk); ?>'
      }
    }
  }
}
</script>

<style>
*,*::before,*::after{box-sizing:border-box}
html,body{font-family:'DM Sans',sans-serif}
h1,h2,h3,h4,h5,h6{font-family:'PT Sans',sans-serif}
body{transition:background-color .3s,color .3s}

/* noise overlay */
body::before{content:'';position:fixed;inset:0;pointer-events:none;z-index:0;opacity:.35;
background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.05'/%3E%3C/svg%3E")}

::-webkit-scrollbar{width:5px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:<?php echo e($accent); ?>;border-radius:99px}

.reveal{opacity:0;transform:translateY(26px);transition:opacity .6s cubic-bezier(.4,0,.2,1),transform .6s cubic-bezier(.4,0,.2,1)}
.reveal.in{opacity:1;transform:none}
.d1{transition-delay:.08s}.d2{transition-delay:.16s}.d3{transition-delay:.24s}.d4{transition-delay:.32s}

.nl{position:relative}
.nl::after{content:'';position:absolute;bottom:-2px;left:0;width:0;height:1.5px;background:currentColor;transition:width .22s cubic-bezier(.4,0,.2,1)}
.nl:hover::after,.nl.on::after{width:100%}
.nl.on{font-weight:500}

.shimmer{position:relative;overflow:hidden}
.shimmer::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:rgba(255,255,255,.18);transform:skewX(-20deg);transition:left .4s cubic-bezier(.4,0,.2,1)}
.shimmer:hover::after{left:160%}

.pf{overflow:hidden;background:#d4d4d8}
.pf img{width:100%;height:100%;object-fit:cover;display:block}

.card-h{transition:transform .28s cubic-bezier(.4,0,.2,1),border-color .18s}
.card-h:hover{transform:translateY(-4px)}

.rich p{margin-bottom:1rem}
.rich h1,.rich h2,.rich h3,.rich h4{font-weight:700;font-size:1.125rem;margin:1.75rem 0 .5rem}
.rich ul,.rich ol{padding-left:1.25rem;margin-bottom:1rem;list-style:disc}
.rich ol{list-style:decimal}
.rich li{margin-bottom:.4rem}
.rich a{color:<?php echo e($accentInk); ?>;text-decoration:underline}
.rich img{max-width:100%;height:auto;border-radius:.75rem}

@media (prefers-reduced-motion: reduce){.reveal{opacity:1;transform:none;transition:none}}
[x-cloak]{display:none!important}
</style>
</head>

<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">

<header class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="sc ? 'bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-zinc-100 dark:border-zinc-900' : ''">
  <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between" aria-label="Main navigation">
    <a href="<?php echo e($home ?: '#hero'); ?>" class="font-display font-bold text-lg tracking-tight"><?php echo e($first ?: $user->name); ?><span class="text-accent">.</span></a>

    <div class="hidden md:flex items-center gap-8">
      <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anchor => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e($home); ?>#<?php echo e($anchor); ?>" class="nl text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" :class="s === '<?php echo e($anchor); ?>' ? 'on text-zinc-900 dark:text-white' : ''"><?php echo e($label); ?></a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="flex items-center gap-2">
      <button @click="dark = !dark" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors" :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'">
        <svg x-show="!dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        <svg x-show="dark" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      </button>

      <button @click="mm = !mm" class="md:hidden p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors" aria-label="Menu" :aria-expanded="mm">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </nav>

  <div x-show="mm" x-cloak x-transition class="md:hidden bg-white dark:bg-zinc-950 border-b border-zinc-100 dark:border-zinc-900">
    <div class="px-6 py-4 flex flex-col gap-3">
      <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anchor => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e($home); ?>#<?php echo e($anchor); ?>" @click="mm = false" class="text-sm text-zinc-600 dark:text-zinc-400 py-1"><?php echo e($label); ?></a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</header>

<main class="relative z-10">
    <?php echo e($slot); ?>

</main>

<footer class="relative z-10 border-t border-zinc-100 dark:border-zinc-900">
  <div class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10">
    <div>
      <a href="<?php echo e($home ?: '#hero'); ?>" class="font-display font-bold text-xl tracking-tight"><?php echo e($first ?: $user->name); ?><span class="text-accent">.</span></a>
      <?php if($user->role): ?><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2"><?php echo e($user->role); ?></p><?php endif; ?>
      <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-4 max-w-xs"><?php echo e(\Illuminate\Support\Str::limit(strip_tags((string) $user->about), 120)); ?></p>
    </div>

    <div>
      <p class="font-display font-bold text-sm uppercase tracking-widest text-zinc-900 dark:text-white mb-4">Explore</p>
      <ul class="space-y-2">
        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anchor => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e($home); ?>#<?php echo e($anchor); ?>" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-accent transition-colors"><?php echo e($label); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>

    <div>
      <p class="font-display font-bold text-sm uppercase tracking-widest text-zinc-900 dark:text-white mb-4">Get in touch</p>
      <ul class="space-y-2 text-sm text-zinc-500 dark:text-zinc-400">
        <?php if($user->address): ?><li><?php echo e($user->address); ?></li><?php endif; ?>
        <?php if($user->email): ?><li><a href="mailto:<?php echo e($user->email); ?>" class="hover:text-accent transition-colors"><?php echo e($user->email); ?></a></li><?php endif; ?>
        <?php if($user->phone): ?><li><a href="https://wa.me/<?php echo e($user->phone); ?>" target="_blank" rel="noopener" class="hover:text-accent transition-colors">+<?php echo e($user->phone); ?></a></li><?php endif; ?>
        <?php if($user->linkedIn_url): ?><li><a href="<?php echo e($user->linkedIn_url); ?>" target="_blank" rel="noopener" class="hover:text-accent transition-colors">LinkedIn</a></li><?php endif; ?>
      </ul>
    </div>
  </div>

  <div class="max-w-6xl mx-auto px-6 pb-10">
    <p class="text-sm text-zinc-400 border-t border-zinc-100 dark:border-zinc-900 pt-6">&copy; <?php echo e(date('Y')); ?> <?php echo e($user->name); ?>. All rights reserved.</p>
  </div>
</footer>

<script>
function folio() {
  return {
    dark: false,
    mm: false,
    sc: false,
    s: '<?php echo e(array_key_first($links)); ?>',

    init() {
      this.dark = localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
      this.$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'));

      window.addEventListener('scroll', () => {
        this.sc = window.scrollY > 20;
        this.updateSection();
      }, { passive: true });

      const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
      document.querySelectorAll('.reveal').forEach(el => io.observe(el));
    },

    updateSection() {
      const ids = <?php echo json_encode(array_reverse(array_keys($links)), 15, 512) ?>;
      const atBottom = (window.innerHeight + window.scrollY) >= document.body.scrollHeight - 60;
      if (atBottom) { this.s = ids[0]; return; }
      for (const id of ids) {
        const el = document.getElementById(id);
        if (el && window.scrollY >= el.offsetTop - 130) { this.s = id; return; }
      }
    }
  }
}
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template3/website/master/master-layout.blade.php ENDPATH**/ ?>
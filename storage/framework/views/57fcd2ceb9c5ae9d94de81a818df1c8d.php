<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user', 'post' => null, 'type' => 'profile']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user', 'post' => null, 'type' => 'profile']); ?>
<?php foreach (array_filter((['user', 'post' => null, 'type' => 'profile']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $html))));

    $siteName = trim((string) $user->name) ?: config('app.name');
    $role = trim((string) $user->role);

    if ($post) {
        $title = $plain($post->title).' | '.$siteName;
        $description = \Illuminate\Support\Str::limit($plain($post->description), 155);
        $image = optional($post->images->first())->url ?: $post->image;
        $published = optional($post->created_at)->toIso8601String();
        $modified = optional($post->updated_at)->toIso8601String();
    } else {
        $title = $siteName.($role ? ' - '.$role : '');
        $description = \Illuminate\Support\Str::limit($plain($user->about) ?: $siteName.($role ? ', '.$role : ''), 155);
        $image = $user->image;
    }

    // Same page, but always on the site's real domain (APP_URL). request()->path()
    // drops any local subfolder such as /myresume/public.
    $base = rtrim((string) config('app.url'), '/');
    $canonical = $base.'/'.ltrim(request()->path(), '/');

    // Social images must be absolute and on the same domain as the canonical.
    $imageUrl = null;
    if ($image) {
        $imagePath = \Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])
            ? ltrim((string) parse_url($image, PHP_URL_PATH), '/')
            : ltrim($image, '/');
        // Strip a local subfolder prefix so the URL works on the live domain too.
        $prefix = trim((string) parse_url(url('/'), PHP_URL_PATH), '/');
        if ($prefix !== '' && \Illuminate\Support\Str::startsWith($imagePath, $prefix.'/')) {
            $imagePath = \Illuminate\Support\Str::after($imagePath, $prefix.'/');
        }
        $imageUrl = $base.'/'.$imagePath;
    }

    // Structured data: the person on the home page, the article on a post page.
    $person = array_filter([
        '@type' => 'Person',
        'name' => $siteName,
        'jobTitle' => $role ?: null,
        'email' => $user->email ? 'mailto:'.$user->email : null,
        'telephone' => $user->phone ? '+'.$user->phone : null,
        'url' => $base.'/'.request()->id,
        'image' => $imageUrl,
        'address' => $user->address ? ['@type' => 'PostalAddress', 'addressLocality' => $user->address] : null,
        'sameAs' => array_values(array_filter([$user->linkedIn_url])),
        'description' => $plain($user->about) ?: null,
    ], fn ($value) => !empty($value));

    $jsonLd = $post
        ? array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => \Illuminate\Support\Str::limit($plain($post->title), 110, ''),
            'description' => $description,
            'image' => $imageUrl,
            'datePublished' => $published ?? null,
            'dateModified' => $modified ?? null,
            'author' => $person,
            'publisher' => $person,
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
        ], fn ($value) => !empty($value))
        : ['@context' => 'https://schema.org'] + $person;
?>

<title><?php echo e($title); ?></title>
<meta name="description" content="<?php echo e($description); ?>">
<link rel="canonical" href="<?php echo e($canonical); ?>">
<meta name="author" content="<?php echo e($siteName); ?>">

<meta property="og:type" content="<?php echo e($post ? 'article' : $type); ?>">
<meta property="og:site_name" content="<?php echo e($siteName); ?>">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:url" content="<?php echo e($canonical); ?>">
<?php if($imageUrl): ?>
<meta property="og:image" content="<?php echo e($imageUrl); ?>">
<meta property="og:image:alt" content="<?php echo e($post ? $plain($post->title) : $siteName); ?>">
<?php endif; ?>
<?php if($post): ?>
<meta property="article:published_time" content="<?php echo e($published); ?>">
<meta property="article:modified_time" content="<?php echo e($modified); ?>">
<meta property="article:author" content="<?php echo e($siteName); ?>">
<?php endif; ?>

<meta name="twitter:card" content="<?php echo e($imageUrl ? 'summary_large_image' : 'summary'); ?>">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>">
<?php if($imageUrl): ?>
<meta name="twitter:image" content="<?php echo e($imageUrl); ?>">
<?php endif; ?>

<script type="application/ld+json"><?php echo json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/website/seo.blade.php ENDPATH**/ ?>
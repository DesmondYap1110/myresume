@props(['user', 'post' => null, 'type' => 'profile'])
{{--
    Search engine + social sharing tags, shared by every website template.

    Canonical URLs use APP_URL so the same page on another host (localhost,
    with or without www) is not treated as a duplicate site.
--}}
@php
    $plain = fn ($html) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $html))));

    $siteName = trim((string) $user->name) ?: config('app.name');
    $role = trim((string) $user->t('role'));

    if ($post) {
        $title = $plain($post->t('title')).' | '.$siteName;
        $description = \Illuminate\Support\Str::limit($plain($post->t('description')), 155);
        $image = optional($post->images->first())->url ?: $post->image;
        $published = optional($post->created_at)->toIso8601String();
        $modified = optional($post->updated_at)->toIso8601String();
    } else {
        $title = $siteName.($role ? ' - '.$role : '');
        $description = \Illuminate\Support\Str::limit($plain($user->t('about')) ?: $siteName.($role ? ', '.$role : ''), 155);
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
        'description' => $plain($user->t('about')) ?: null,
    ], fn ($value) => !empty($value));

    $jsonLd = $post
        ? array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => \Illuminate\Support\Str::limit($plain($post->t('title')), 110, ''),
            'description' => $description,
            'image' => $imageUrl,
            'datePublished' => $published ?? null,
            'dateModified' => $modified ?? null,
            'author' => $person,
            'publisher' => $person,
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
        ], fn ($value) => !empty($value))
        : ['@context' => 'https://schema.org'] + $person;
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="author" content="{{ $siteName }}">

<meta property="og:type" content="{{ $post ? 'article' : $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
@if($imageUrl)
<meta property="og:image" content="{{ $imageUrl }}">
<meta property="og:image:alt" content="{{ $post ? $plain($post->t('title')) : $siteName }}">
@endif
@if($post)
<meta property="article:published_time" content="{{ $published }}">
<meta property="article:modified_time" content="{{ $modified }}">
<meta property="article:author" content="{{ $siteName }}">
@endif

<meta name="twitter:card" content="{{ $imageUrl ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($imageUrl)
<meta name="twitter:image" content="{{ $imageUrl }}">
@endif

<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

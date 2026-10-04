<?php

/*
 * Why is the site not switching language?
 *
 * Run from the project root:  php langcheck.php
 *
 * Bootstraps Laravel the same way a web request does, so it sees exactly
 * what the site sees - including any cached config. Delete this file when
 * you are done with it.
 */

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$ok = fn ($b) => $b ? 'OK  ' : 'FAIL';

echo "\n--- files ---\n";
printf("%s config/locales.php exists\n", $ok(is_file(__DIR__.'/config/locales.php')));

foreach (['en', 'ms', 'zh'] as $locale) {
    printf("%s lang/%s/site.php  %s lang/%s/admin.php\n",
        $ok(is_file(__DIR__."/lang/$locale/site.php")), $locale,
        $ok(is_file(__DIR__."/lang/$locale/admin.php")), $locale);
}

echo "\n--- config ---\n";
$supported = (array) config('locales.supported', []);
printf("%s config('locales.supported') -> %s\n",
    $ok(count($supported) > 1),
    $supported ? implode(', ', array_keys($supported)) : '(EMPTY - config cache is stale)');

printf("%s config cache file %s\n",
    $ok(true),
    is_file(__DIR__.'/bootstrap/cache/config.php') ? 'present (rebuild it after every pull)' : 'absent (config read live)');

echo "\n--- translations ---\n";
foreach (['en', 'ms', 'zh'] as $locale) {
    app()->setLocale($locale);
    $label = __('site.section.experience');
    printf("%s %s: site.section.experience -> %s\n", $ok($label !== 'site.section.experience'), $locale, $label);
}

echo "\n--- middleware ---\n";
$kernel = file_get_contents(__DIR__.'/app/Http/Kernel.php');
printf("%s SetLocale registered in the web group\n", $ok(str_contains($kernel, 'SetLocale')));
printf("%s SetLocale class file exists\n", $ok(is_file(__DIR__.'/app/Http/Middleware/SetLocale.php')));

echo "\n--- database ---\n";
try {
    $hasTranslations = Illuminate\Support\Facades\Schema::hasColumn('users', 'translations');
    printf("%s users.translations column (run: php artisan migrate)\n", $ok($hasTranslations));
    printf("%s blog_image.locale column\n", $ok(Illuminate\Support\Facades\Schema::hasColumn('blog_image', 'locale')));
    printf("%s users.social_links column\n", $ok(Illuminate\Support\Facades\Schema::hasColumn('users', 'social_links')));
} catch (Throwable $e) {
    echo "FAIL database: ".$e->getMessage()."\n";
}

echo "\nIf anything above says FAIL, the fix is almost always:\n";
echo "  php artisan migrate --force\n";
echo "  php artisan config:clear && php artisan config:cache\n";
echo "  php artisan view:clear  && php artisan view:cache\n";
echo "  php artisan route:clear && php artisan route:cache\n\n";

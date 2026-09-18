<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Makes sure a deployment can be logged into.
 *
 * On an empty database (a fresh server) the administrator from config/admin.php
 * is created, so "php artisan migrate" is all that stands between deploying and
 * signing in. On a database that already has users nothing is created - the
 * admin flag simply goes to the matching account, or to the first one.
 */
return new class extends Migration
{
    public function up(): void
    {
        $email = (string) config('admin.email');

        $existing = DB::table('users')->where('email', $email)->first();

        if ($existing) {
            DB::table('users')->where('id', $existing->id)->update(['is_admin' => true]);

            return;
        }

        // An installation that already has accounts keeps them; the earliest
        // one becomes the administrator rather than adding a stranger.
        if (DB::table('users')->exists()) {
            $first = DB::table('users')->orderBy('id')->first();
            DB::table('users')->where('id', $first->id)->update(['is_admin' => true]);

            return;
        }

        DB::table('users')->insert([
            'name' => (string) config('admin.name'),
            'email' => $email,
            'password' => Hash::make((string) config('admin.password')),
            'slug' => $this->freeSlug((string) config('admin.slug') ?: Str::slug((string) config('admin.name'))),
            'website_template' => (string) config('admin.template'),
            'status' => 1,
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Only remove the account if it is still untouched, so a real profile
        // is never deleted by rolling back.
        DB::table('users')
            ->where('email', (string) config('admin.email'))
            ->whereNull('about')
            ->whereNull('phone')
            ->delete();
    }

    private function freeSlug(string $slug): string
    {
        $base = Str::slug($slug) ?: 'admin';
        $slug = $base;
        $n = 2;

        while (DB::table('users')->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$n++;
        }

        return $slug;
    }
};

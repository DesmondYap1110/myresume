<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Friendly website address, e.g. /desmond-yap instead of /MQ==.
 * Existing base64 links keep working and redirect to the slug.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug', 60)->nullable()->unique()->after('name');
        });

        // Give every existing user a slug made from their name.
        $used = [];
        foreach (DB::table('users')->orderBy('id')->get(['id', 'name']) as $user) {
            $base = Str::slug($user->name) ?: 'user-'.$user->id;
            $slug = $base;
            $i = 2;
            while (in_array($slug, $used, true) || DB::table('users')->where('slug', $slug)->exists()) {
                $slug = $base.'-'.$i++;
            }
            $used[] = $slug;
            DB::table('users')->where('id', $user->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The language a member's public site opens in.
 *
 * Null means "decide from the visitor's browser", which is what happened for
 * everybody before this column existed, so existing sites keep their
 * behaviour until somebody picks a language under Profile.
 *
 * A visitor who switches language still wins: that choice is kept in the
 * session and SetLocale reads it first.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'default_locale')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('default_locale', 5)->nullable()->after('slug')
                    ->comment('Profile: language the public site opens in. Null = follow the browser.');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'default_locale')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('default_locale');
            });
        }
    }
};

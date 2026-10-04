<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Which language a blog image belongs to.
 *
 * NULL means "every language" - that is what existing rows keep, so nothing
 * disappears from a post that was written before this. A row with a locale
 * is shown only when the site is being read in that language, and a language
 * with no images of its own falls back to the NULL set.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blog_image') && !Schema::hasColumn('blog_image', 'locale')) {
            Schema::table('blog_image', function (Blueprint $table) {
                $table->string('locale', 5)->nullable()->after('blog_id')
                    ->comment('NULL = shown in every language.');

                $table->index(['blog_id', 'locale'], 'blog_image_blog_locale_index');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blog_image') && Schema::hasColumn('blog_image', 'locale')) {
            Schema::table('blog_image', function (Blueprint $table) {
                $table->dropIndex('blog_image_blog_locale_index');
                $table->dropColumn('locale');
            });
        }
    }
};

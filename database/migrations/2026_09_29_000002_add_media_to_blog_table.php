<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Video and social links a post plays alongside its text.
 *
 * Stored as the parsed result rather than the raw URL, so rendering never has
 * to trust or re-parse what was typed:
 *
 *   [{"provider":"youtube","id":"dQw4w9WgXcQ","url":"…","embed":"…","label":"YouTube"}]
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blog') && !Schema::hasColumn('blog', 'media')) {
            Schema::table('blog', function (Blueprint $table) {
                $table->json('media')->nullable()->after('image')
                    ->comment('Embedded YouTube / Instagram / X links, already parsed.');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blog') && Schema::hasColumn('blog', 'media')) {
            Schema::table('blog', function (Blueprint $table) {
                $table->dropColumn('media');
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Where a member can be found elsewhere, and whether each link is shown.
 *
 *   {
 *     "networks": {"linkedin": {"url": "https://…", "show": true}},
 *     "custom":   [{"label": "Behance", "url": "https://…", "show": true}]
 *   }
 *
 * One column rather than a table: nothing ever searches across these, they
 * are always read with the member, and which networks exist is
 * config/social.php - so adding one never needs a migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'social_links')) {
            Schema::table('users', function (Blueprint $table) {
                $table->json('social_links')->nullable()->after('linkedIn_url')
                    ->comment('Profile > Social Links: known networks, plus any links added by hand.');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'social_links')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('social_links');
            });
        }
    }
};

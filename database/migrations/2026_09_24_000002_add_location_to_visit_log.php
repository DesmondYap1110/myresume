<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Where each visitor came from, filled in the first time the Visitor page
 * shows that address. Nothing is looked up while somebody is browsing the
 * public site, so visits stay as cheap to record as they were.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visit_log', function (Blueprint $table) {
            $table->string('country', 60)->nullable()->after('ip_address');
            $table->string('city', 60)->nullable()->after('country');
            $table->timestamp('located_at')->nullable()->after('city')
                ->comment('When the address was looked up; NULL means not yet.');
        });

        // The Visitor page reads one owner's rows newest first.
        Schema::table('visit_log', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'visit_log_user_created_index');
        });
    }

    public function down(): void
    {
        Schema::table('visit_log', function (Blueprint $table) {
            $table->dropIndex('visit_log_user_created_index');
            $table->dropColumn(['country', 'city', 'located_at']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Resolving a location writes the answer to every row sharing that address,
 * and reads them back again. Both look the address up directly, so without
 * this they scan the whole table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visit_log', function (Blueprint $table) {
            $table->index('ip_address', 'visit_log_ip_index');
        });
    }

    public function down(): void
    {
        Schema::table('visit_log', function (Blueprint $table) {
            $table->dropIndex('visit_log_ip_index');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Every inbox query filters by user_id (+ status, + read_status in that
 * order), so one composite index covers all three. Needed now that the
 * unread count is polled every few seconds instead of loaded once per page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inbox', function (Blueprint $table) {
            $table->index(['user_id', 'status', 'read_status'], 'inbox_user_status_read_index');
        });
    }

    public function down(): void
    {
        Schema::table('inbox', function (Blueprint $table) {
            $table->dropIndex('inbox_user_status_read_index');
        });
    }
};

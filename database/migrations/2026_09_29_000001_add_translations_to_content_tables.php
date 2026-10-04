<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A member's content in the other languages, kept on the row it belongs to:
 *
 *   {"ms": {"role": "Jurutera Perisian"}, "zh": {"role": "软件工程师"}}
 *
 * One column rather than a translations table, so there is nothing to join,
 * nothing to keep in step, and deleting a record takes its translations with
 * it. Which fields each table offers is config/locales.php, not schema, so
 * adding a language or a field needs no migration.
 */
return new class extends Migration
{
    /** Tables whose rows a member can translate. */
    private const tables = [
        'users',
        'experience',
        'education',
        'project',
        'service',
        'skill',
        'testimonial',
        'blog',
    ];

    public function up(): void
    {
        foreach (self::tables as $table) {
            if (!Schema::hasTable($table) || Schema::hasColumn($table, 'translations')) {
                continue;
            }

            Schema::table($table, function (Blueprint $table) {
                $table->json('translations')->nullable()
                    ->comment('locale => field => text. Missing means "as originally written".');
            });
        }
    }

    public function down(): void
    {
        foreach (self::tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'translations')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('translations');
                });
            }
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The assistant can run on Claude (paid), a local Ollama model (free and
 * open source) or any OpenAI-compatible endpoint (OpenRouter, Groq, LM Studio).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_setting', function (Blueprint $table) {
            $table->string('provider', 20)->default('ollama')->after('user_id')
                ->comment('claude | ollama | compatible');
            $table->string('base_url')->nullable()->after('api_key')
                ->comment('Ollama or OpenAI-compatible server URL.');
        });

        // Rows created before this migration were Claude-only.
        DB::table('ai_setting')->whereNotNull('api_key')->update(['provider' => 'claude']);
    }

    public function down(): void
    {
        Schema::table('ai_setting', function (Blueprint $table) {
            $table->dropColumn(['provider', 'base_url']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Claude API credentials for the AI Assistant, one row per user.
 * The key itself is encrypted by the model.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_setting', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->text('api_key')->nullable()->comment('Anthropic API key, encrypted at rest.');
            $table->string('model', 60)->default('claude-opus-5');
            $table->boolean('enabled')->default(true);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_setting');
    }
};

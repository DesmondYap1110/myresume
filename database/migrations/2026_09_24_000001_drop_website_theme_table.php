<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Websites now follow the back-office theme, so the per-template colour
 * scheme is gone along with the table that stored it.
 *
 * Rolling back recreates the table empty: the feature that wrote to it no
 * longer exists, so there is nothing to put back.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('website_theme');
    }

    public function down(): void
    {
        Schema::create('website_theme', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('template', 30);
            $table->string('preset', 40)->nullable();
            $table->json('colors')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'template']);
        });
    }
};

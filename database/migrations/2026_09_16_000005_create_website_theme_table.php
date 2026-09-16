<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Colours for the public website, kept per user and per template, so each
 * design remembers its own scheme. With no row, the website follows the
 * back-office theme in theme_setting.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_theme', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('template', 30)->comment('Key in config/website_templates.php.');
            $table->string('preset', 40)->nullable()->comment('Preset in config/branding.php. NULL = follow the back office.');
            $table->json('colors')->nullable()->comment('Custom colours over the preset, token => #RRGGBB.');
            $table->timestamps();

            $table->unique(['user_id', 'template']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_theme');
    }
};

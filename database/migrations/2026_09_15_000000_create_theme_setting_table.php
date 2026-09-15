<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_setting', function (Blueprint $table) {
            $table->id();
            $table->string('preset', 40)->nullable()
                ->comment('Key of a preset in config/branding.php. NULL = config theme.');
            $table->json('colors')->nullable()
                ->comment('Custom colours over the preset, token => #RRGGBB.');
            $table->string('login_background_image')->nullable()
                ->comment('Path under public/, or "none" for colour only. NULL = config.');
            $table->string('login_background_color', 7)->nullable();
            $table->unsignedTinyInteger('login_overlay')->nullable()
                ->comment('0-80, percent black over the login image.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_setting');
    }
};

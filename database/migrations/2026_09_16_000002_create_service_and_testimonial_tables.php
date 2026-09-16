<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon', 40)->default('code')->comment('Key in config/service_icons.php.');
            $table->text('description');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->integer('status')->default(1);
            $table->string('user_id');
            $table->timestamps();

            $table->index(['user_id', 'sort_order']);
        });

        Schema::create('testimonial', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable()->comment('Role and company, e.g. "CTO, Acme".');
            $table->text('message');
            $table->string('image')->nullable()->comment('Photo path under public/.');
            $table->unsignedTinyInteger('rating')->default(5)->comment('1-5 stars.');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->integer('status')->default(1);
            $table->string('user_id');
            $table->timestamps();

            $table->index(['user_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service');
        Schema::dropIfExists('testimonial');
    }
};

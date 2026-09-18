<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('level')->default(80)->comment('Percentage, 0-100. Only template 4 shows it.');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->integer('status')->default(1);
            $table->string('user_id');
            $table->timestamps();

            $table->index(['user_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visit_log', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_log');
    }
};

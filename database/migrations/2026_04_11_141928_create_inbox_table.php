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
        Schema::create('inbox', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("subject");
            $table->longText("description");
            $table->integer("read_status")->default(0);
            $table->integer("status")->default(1);
            $table->string("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbox');
    }
};

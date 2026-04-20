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
        Schema::create('experience', function (Blueprint $table) {
            $table->id();
            $table->string("company");
            $table->string("role");
            $table->bigInteger('work_status')->nullable()->default(0)->before('start_date');
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->longText("detail");
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
        Schema::dropIfExists('experience');
    }
};

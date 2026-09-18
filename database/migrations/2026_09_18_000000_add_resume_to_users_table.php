<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A downloadable resume (PDF) per user. The file lives in storage/app/resumes,
 * outside the web root, and is served through a route.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('resume')->nullable()->after('image');
            $table->string('resume_name')->nullable()->after('resume');
            $table->timestamp('resume_uploaded_at')->nullable()->after('resume_name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['resume', 'resume_name', 'resume_uploaded_at']);
        });
    }
};

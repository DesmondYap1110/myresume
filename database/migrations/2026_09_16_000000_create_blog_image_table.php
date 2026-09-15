<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A blog post can have several images. blog.image stays as the cover (the
 * first image), so anything reading it keeps working.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_image', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blog')->cascadeOnDelete();
            $table->string('path')->comment('Path under public/ (uploads/abc.jpg) or a full URL for older rows.');
            $table->unsignedSmallInteger('sort_order')->default(0)->comment('0 = cover, shown first.');
            $table->timestamps();

            $table->index(['blog_id', 'sort_order']);
        });

        // Every existing post keeps its current image as the first gallery image.
        $now = now();
        DB::table('blog')->whereNotNull('image')->where('image', '!=', '')->orderBy('id')
            ->each(function ($blog) use ($now) {
                DB::table('blog_image')->insert([
                    'blog_id' => $blog->id,
                    'path' => $blog->image,
                    'sort_order' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_image');
    }
};

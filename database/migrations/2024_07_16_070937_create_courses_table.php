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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->integer('version_number');
            $table->boolean('has_draft')->default(false);
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('set null');
            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('set null');
            $table->foreignId('subsubcategory_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('set null');
            $table->string('level')->nullable();
            $table->string('status')->default('published'); // published, unpublished
            $table->string('language')->default('English');
            $table->foreignId('instructor_id')->constrained('instructors');
            $table->string('thumbnail')->nullable();
            $table->string('promotional_video')->nullable();
            $table->float('price')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->integer('enrollment_count')->default(0);
            $table->integer('sections_count')->default(0);
            $table->integer('lectures_count')->default(0);
            $table->float('rating')->default(0)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

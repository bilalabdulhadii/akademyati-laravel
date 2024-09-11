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
        Schema::create('course_versions', function (Blueprint $table) {
            $table->id();
            $table->integer('version_number')->nullable();
            $table->foreignId('course_id')
                ->nullable()
                ->constrained('courses')
                ->onDelete('cascade');
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
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
            $table->string('status')->default('draft'); // draft, pending, accepted, rejected, active, old
            $table->string('language')->default('English');
            $table->foreignId('instructor_id')->constrained('instructors');
            $table->string('thumbnail')->nullable();
            $table->string('promotional_video')->nullable();
            $table->float('price')->default(-1);
            $table->integer('sections_count')->default(0);
            $table->integer('lectures_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->integer('duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_versions');
    }
};

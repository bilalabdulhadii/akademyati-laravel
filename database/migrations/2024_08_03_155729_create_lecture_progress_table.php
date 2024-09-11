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
        Schema::create('lecture_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade');
            $table->foreignId('enrollment_id')
                ->constrained('enrollments')
                ->onDelete('cascade');
            $table->foreignId('lecture_id')
                ->nullable()
                ->constrained('lectures')
                ->onDelete('set null');
            $table->boolean('is_done')->default(false);
            $table->integer('lecture_order')->nullable();
            $table->integer('section_order')->nullable();
            $table->integer('lecture_duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_progress');
    }
};

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
        Schema::create('progress', function (Blueprint $table) {
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
            $table->foreignId('section_id')
                ->nullable()
                ->constrained('sections')
                ->onDelete('set null');
            $table->foreignId('lecture_id')
                ->nullable()
                ->constrained('lectures')
                ->onDelete('set null');

            $table->integer('section_order')->default(1);
            $table->integer('lecture_order')->default(1);

            $table->float('progress_percentage')->default(0);
            $table->integer('lectures_count')->default(0);
            $table->integer('sections_count')->default(0);
            $table->integer('completed_lectures')->default(0);
            $table->integer('completed_sections')->default(0);

            $table->string('status')->default('unfinished'); // unfinished, completed
            $table->timestamp('last_active')->nullable();
            $table->integer('time_spent')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};

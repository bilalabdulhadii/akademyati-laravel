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
        Schema::create('review_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->constrained('course_versions')
                ->onDelete('cascade');
            $table->foreignId('admin_saw')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->foreignId('admin_finished')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->integer('order')->default(1);
            $table->string('status')->default('pending'); // pending, started, rejected, accepted, cancelled
            $table->boolean('is_seen')->default(false);
            $table->timestamp('seen_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->longText('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_versions');
    }
};

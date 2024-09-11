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
        Schema::create('course_attribute_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->constrained('course_versions')
                ->onDelete('cascade');
            $table->enum('type', [
                'prerequisite', 'objective',
                'welcome_message', 'congratulations_message',
                'announcement', 'benefit']);
            $table->longText('content')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_attribute_versions');
    }
};

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
        Schema::create('resource_lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id')
                ->constrained('lectures')
                ->onDelete('cascade');
            $table->integer('section_order')->nullable();
            $table->integer('order')->default(0);
            $table->string('resource_url')->nullable();
            $table->integer('duration')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_lectures');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->timestamp('joined_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('birth')->nullable();
            $table->string('nationality')->nullable();
            $table->string('education_level')->nullable();
            $table->string('field_of_expertise')->nullable();
            $table->string('professional_title')->nullable();
            $table->string('short_professional_title')->nullable();
            $table->text('certifications')->nullable();
            $table->text('experience')->nullable();
            $table->string('language')->nullable();
            $table->boolean('status')->default(true);
            $table->string('availability')->nullable();
            $table->float('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};

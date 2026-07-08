<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('scholarship_applications')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('criteria_id')->constrained('evaluation_criteria')->cascadeOnDelete();
            $table->decimal('score_value', 5, 2); // e.g. 0-100 per criterion
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['application_id', 'reviewer_id', 'criteria_id'], 'unique_score_entry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
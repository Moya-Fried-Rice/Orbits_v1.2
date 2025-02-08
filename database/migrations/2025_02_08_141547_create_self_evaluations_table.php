<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('self_evaluations', function (Blueprint $table) {
            $table->id('self_evaluation_id');
            $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'))->nullable(false);
            $table->foreignId('faculty_id')->constrained('faculties', 'faculty_id')->onDelete('cascade');
            $table->foreignId('course_section_id')->constrained('course_sections', 'course_section_id')->onDelete('cascade');
            $table->foreignId('survey_id')->constrained('surveys', 'survey_id')->onDelete('cascade');
            $table->string('comment')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('evaluated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_evaluations');
    }
};

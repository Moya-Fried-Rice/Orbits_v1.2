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
        Schema::create('survey_period', function (Blueprint $table) {
            $table->foreignId('survey_id')->constrained('surveys', 'survey_id')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('evaluation_periods', 'period_id')->onDelete('cascade');
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Soft delete column (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_period');
    }
};

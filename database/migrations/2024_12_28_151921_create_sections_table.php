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
        Schema::create('sections', function (Blueprint $table) {
            $table->id('section_id');
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade'); // Foreign key to the programs table
            $table->foreignId('period_id')->default(1)->constrained('evaluation_periods', 'period_id')->onDelete('cascade'); // Foreign key to the evaluation_periods table with default value 1
            $table->integer('year_level'); // Year level (e.g., 1st year, 2nd year, etc.)
            $table->integer('section_number'); // Section number (e.g., 102 for 1st year, 2nd section)
            $table->timestamps();
        });              
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};

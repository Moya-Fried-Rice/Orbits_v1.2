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
        Schema::create('response_selves', function (Blueprint $table) {
            $table->id('response_id');
            $table->foreignId('self_evaluation_id')->constrained('self_evaluations', 'self_evaluation_id')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions', 'question_id')->onDelete('cascade');
            $table->integer('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

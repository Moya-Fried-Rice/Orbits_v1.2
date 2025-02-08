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
        Schema::create('user_evaluations', function (Blueprint $table) {
            $table->id('user_evaluation_id');
            $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'))->nullable(false);
            $table->foreignId('evaluation_id')->constrained('evaluations', 'evaluation_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
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
        Schema::dropIfExists('user_evaluations');
    }
};

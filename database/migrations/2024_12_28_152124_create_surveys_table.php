<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id('survey_id'); // Auto-increment primary key
            $table->string('survey_name'); // Name of the survey
            $table->enum('target_role', ['student', 'peer', 'self', 'chair']); // Restricted to specific roles
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys'); // Drop the surveys table if rolled back
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the survey_roles table
        Schema::create('survey_roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->unsignedBigInteger('survey_id');
            $table->string('role');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('survey_id')->references('survey_id')->on('surveys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_roles');
    }
}

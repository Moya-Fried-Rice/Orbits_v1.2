<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('program_courses', function (Blueprint $table) {
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade'); // Foreign key to the programs table
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade'); // Foreign key to the courses table
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_courses'); // Drop the program_courses table if the migration is rolled back
    }
}

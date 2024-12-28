<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('program_id'); // Auto-increment primary key for programs table
            $table->string('program_code'); // Unique code for the program (e.g., "CS101")
            $table->string('program_name'); // Name of the program (e.g., "Computer Science")
            $table->text('program_description'); // A detailed description of the program
            $table->foreignId('department_id')->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to the departments table
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs'); // Drop the programs table if the migration is rolled back
    }
}

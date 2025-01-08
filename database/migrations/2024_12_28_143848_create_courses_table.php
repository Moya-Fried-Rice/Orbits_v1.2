<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id'); // Primary key
            $table->string('course_name')->unique(); // Course name
            $table->text('course_description')->nullable(); // Course description (nullable)
            $table->string('course_code')->unique(); // Course code, should be unique
            $table->foreignId('department_id')->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to the departments table with cascade delete
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Add soft deletes (deleted_at column)
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}

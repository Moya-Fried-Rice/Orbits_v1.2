<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id'); // Auto-increment primary key
            $table->string('username')->unique(); // Unique username
            $table->string('password'); // Password
            $table->string('email')->unique(); // Unique email
            $table->timestamps(); // created_at, updated_at
            $table->string('first_name'); // First name of the student
            $table->string('last_name'); // Last name of the student
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade'); // Foreign key to programs table
            $table->string('phone_number')->nullable(); // Optional phone number
            $table->string('profile_image')->nullable(); // Optional profile image path
            $table->softDeletes(); // Soft delete column (deleted_at)
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}


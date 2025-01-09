<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id('faculty_id'); // Auto-increment primary key
            $table->foreignId('user_id')->unique()->constrained('users', 'user_id')->onDelete('cascade'); // Foreign key to the users table
            $table->foreignId('department_id')->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to departments table
            $table->string('first_name'); // First name
            $table->string('last_name'); // Last name
            $table->string('phone_number')->nullable(); // Optional phone number
            $table->string('profile_image')->nullable(); // Optional profile image
            $table->softDeletes(); // Add soft deletes (deleted_at column)
            $table->timestamps(); // created_at, updated_at
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculties');
    }
}

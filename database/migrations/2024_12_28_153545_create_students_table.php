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
            $table->uuid('uuid')->default(DB::raw('UUID()'))->nullable(false);
            $table->foreignId('user_id')->unique()->constrained('users', 'user_id')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade'); // Foreign key to programs table
            $table->string('first_name'); // First name of the student
            $table->string('last_name'); // Last name of the student
            $table->string('phone_number')->nullable(); // Optional phone number
            $table->string('profile_image')->nullable(); // Optional profile image path
            $table->softDeletes(); // Soft delete column (deleted_at)
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
        Schema::dropIfExists('students');
    }
}

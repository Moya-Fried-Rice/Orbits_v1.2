<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramChairsTable extends Migration
{
    public function up()
    {
        Schema::create('program_chairs', function (Blueprint $table) {
            $table->id('chair_id'); // Auto-increment primary key for program_chairs table
            $table->string('username')->unique(); // Unique username for program chair
            $table->string('password'); // Password for program chair
            $table->string('email')->unique(); // Unique email address for program chair
            $table->timestamps(); // created_at, updated_at
            $table->string('first_name'); // First name of the program chair
            $table->string('last_name'); // Last name of the program chair
            $table->foreignId('department_id')->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to the departments table
            $table->string('profile_image')->nullable(); // Profile image of the program chair (nullable)
            $table->softDeletes(); // Soft delete column (deleted_at)
        });        
    }

    public function down()
    {
        Schema::dropIfExists('program_chairs'); // Drop the program_chairs table if the migration is rolled back
    }
}

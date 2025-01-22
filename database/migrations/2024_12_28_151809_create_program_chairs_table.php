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
            $table->uuid('uuid')->default(DB::raw('UUID()'))->nullable(false);
            $table->foreignId('user_id')->unique()->constrained('users', 'user_id')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('department_id')->nullable()->unique()->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to departments table
            $table->string('first_name'); // First name of the program chair
            $table->string('last_name'); // Last name of the program chair
            $table->string('profile_image')->nullable(); // Profile image of the program chair (nullable)
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->timestamps(); // created_at, updated_at
        });        
    }

    public function down()
    {
        Schema::dropIfExists('program_chairs'); // Drop the program_chairs table if the migration is rolled back
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProgramChairsTable extends Migration
{
    public function up()
    {
        Schema::create('program_chairs', function (Blueprint $table) {
            $table->id('chair_id'); // Auto-increment primary key for program_chairs table
            $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'))->nullable(false);
            $table->foreignId('user_id')->unique()->constrained('users', 'user_id')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('department_id')->nullable()->unique()->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to departments table
            $table->string('first_name'); // First name of the program chair
            $table->string('last_name'); // Last name of the program chair
            $table->string('profile_image')->default('default_images/default_profile.png');
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });        
    }

    public function down()
    {
        Schema::dropIfExists('program_chairs'); // Drop the program_chairs table if the migration is rolled back
    }
}

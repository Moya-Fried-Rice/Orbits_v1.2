<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('program_id'); // Auto-increment primary key for programs table
            $table->uuid('uuid')->default(DB::raw('UUID()'))->nullable(false);
            $table->string('program_code')->unique(); // Unique code for the program (e.g., "CS101")
            $table->string('program_name')->unique(); // Name of the program (e.g., "Computer Science")
            $table->string('abbreviation')->nullable(); // Course name
            $table->text('program_description'); // A detailed description of the program
            $table->foreignId('department_id')->constrained('departments', 'department_id')->onDelete('cascade'); // Foreign key to the departments table
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes(); // Add soft delete column (deleted_at)
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('programs'); // Drop the programs table if the migration is rolled back
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id('department_id'); // Primary key
            $table->string('department_name')->unique();; // Department name
            $table->text('department_description')->nullable(); // Department description (nullable)
            $table->string('department_code')->unique(); // Department code, should be unique
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
        Schema::dropIfExists('departments');
    }
}

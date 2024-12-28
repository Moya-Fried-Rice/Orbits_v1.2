<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('admin_id'); // Primary key
            $table->string('username')->unique(); // Admin's username
            $table->string('password'); // Admin's password
            $table->string('email')->unique(); // Admin's email address
            $table->timestamps(); // created_at and updated_at
            $table->string('first_name'); // Admin's first name
            $table->string('last_name'); // Admin's last name
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}

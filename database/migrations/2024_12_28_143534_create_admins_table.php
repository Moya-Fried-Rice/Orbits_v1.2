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
            $table->string('password'); // Admin's password (hashed)
            $table->string('email')->unique(); // Admin's email address
            $table->string('first_name'); // Admin's first name
            $table->string('last_name'); // Admin's last name
            $table->string('phone')->nullable(); // Admin's phone number (optional)
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->softDeletes(); // Add soft deletes (deleted_at column)
            $table->timestamps(); // created_at and updated_at
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

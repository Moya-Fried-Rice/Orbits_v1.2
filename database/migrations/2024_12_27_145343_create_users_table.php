<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'))->nullable(false);
            $table->string('first_name'); // First name of the student
            $table->string('last_name'); // Last name of the student
            $table->string('phone_number')->nullable(); // Optional phone number
            $table->string('profile_image')->default('default_images/default_profile.png'); // Optional profile image path
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id')
            ->default(1) // Set default role to 'student'
            ->nullable(false); // Ensure this column cannot be null
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

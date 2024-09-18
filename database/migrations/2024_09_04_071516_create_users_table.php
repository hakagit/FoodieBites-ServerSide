<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // User name
            $table->string('email')->unique(); // User email
            $table->string('password'); // User password
            $table->enum('role', ['customer', 'admin'])->default('customer'); // User role
            $table->timestamps();
            $table->softDeletes(); // Soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

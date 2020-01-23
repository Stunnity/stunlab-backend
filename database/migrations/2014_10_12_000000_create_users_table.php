<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->engine = 'InnoDB';
            $table->string('username')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->timestamps();
            $table->rememberToken()->nullable();
            $table->date('email_verified_at')->nullable();
            $table->date('phone_verified_at')->nullable();
            $table->primary('username');

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

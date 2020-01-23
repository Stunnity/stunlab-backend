<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('username');
            $table->string('provider_providerName');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('password');
            $table->text('description');
            $table->timestamps();
            $table->rememberToken()->nullable();
            $table->primary('username');
            $table->foreign('provider_providerName')->references('providerName')->on('providers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}

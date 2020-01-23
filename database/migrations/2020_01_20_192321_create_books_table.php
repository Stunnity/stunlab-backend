<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('ISBN');
            $table->string('name');
            $table->string('publisher');
            $table->string('level_levelName');
            $table->string('provider_providerName');
            $table->string('category_categoryName');
            $table->text('description');
            $table->timestamps();
            $table->primary('ISBN');
            $table->foreign('provider_providerName')->references('providerName')->on('providers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level_levelName')->references('levelName')->on('levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_categoryName')->references('categoryName')->on('categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}

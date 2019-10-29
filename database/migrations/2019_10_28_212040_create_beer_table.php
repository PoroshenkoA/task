<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('description', 255);
            $table->bigInteger('typeID')->unsigned()->nullable();
            $table->bigInteger('makerID')->unsigned()->nullable();
            $table->foreign('typeID')->references('id')->on('BeerTypes');
            $table->foreign('makerID')->references('id')->on('BeerMakers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beer');
    }
}

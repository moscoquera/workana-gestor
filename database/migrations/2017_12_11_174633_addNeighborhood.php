<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNeighborhood extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('neighborhoods',function(Blueprint $table){
            $table->increments('id');
            $table->text('name',255);
            $table->unsignedInteger('town_id')->nullable();
            $table->unsignedInteger('city_id');
            $table->timestamps();

            $table->foreign('town_id')->references('id')->on('towns');
            $table->foreign('city_id')->references('id')->on('cities');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('neighborhoods');
    }
}

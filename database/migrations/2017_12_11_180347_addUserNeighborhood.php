<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserNeighborhood extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function(Blueprint $table){
           $table->unsignedInteger('town_id')->nullable();
           $table->unsignedInteger('neighborhood_id')->nullable();

           $table->foreign('town_id')->references('id')->on('towns');
           $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function(Blueprint $table){

            $table->dropForeign(['town_id']);
            $table->dropForeign(['neighborhood_id']);

            $table->dropColumn('town_id');
            $table->dropColumn('neighborhood_id');

        });
    }
}

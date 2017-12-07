<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityElectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_election_candidates',function (Blueprint $table){
           $table->increments('id');
           $table->unsignedInteger('city_id');
           $table->unsignedInteger('election_candidate_id');
           $table->integer('votes');
           $table->timestamps();


           $table->foreign('city_id')->references('id')->on('cities');
           $table->foreign('election_candidate_id')->references('id')->on('election_candidates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city_election_candidates');
    }
}

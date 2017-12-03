<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EconomicalSupports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('economical_supports',function (Blueprint $table){
           $table->increments('id');
           $table->unsignedInteger('election_user_id');
           $table->date('date');
           $table->integer('value');
           $table->integer('type');
           $table->timestamps();
           $table->softDeletes();

           $table->foreign('election_user_id')->references('id')->on('election_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('economical_supports');
    }
}

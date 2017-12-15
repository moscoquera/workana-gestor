<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEducationalInstitutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educational_institutions',function (Blueprint $table){
           $table->increments('id');
           $table->text('name',100);
           $table->unsignedInteger('department_id');
           $table->unsignedInteger('city_id');
           $table->timestamps();

           $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::drop('educational_institutions');
    }
}

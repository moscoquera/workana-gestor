<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('city_id')->nullable();
            $table->string('poll_place',500)->nullable();
            $table->string('address',500)->nullable();
            $table->string('phone',30)->nullable();
            $table->string('contact',100)->nullable();
            $table->date('enter_date')->nullable();

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
        Schema::dropIfExists('support_houses');
    }
}

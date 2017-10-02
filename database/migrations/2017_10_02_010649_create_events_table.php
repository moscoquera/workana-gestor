<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('dateandtime');
            $table->string('name');
            $table->string('address');
            $table->unsignedInteger('user_id');
            $table->string('observations');
            $table->string('levels');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events',function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('events');
    }
}

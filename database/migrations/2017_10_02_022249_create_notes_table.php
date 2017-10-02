<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->string('value',2048);
            $table->unsignedInteger('made_by_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('made_by_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['made_by_id']);
        });

        Schema::dropIfExists('notes');
    }
}

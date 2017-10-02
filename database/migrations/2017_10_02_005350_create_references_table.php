<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curriculum_id');
            $table->char('type',1);
            $table->string('fullname');
            $table->string('profession');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('curriculum_id')->references('id')->on('curriculums');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('references',function (Blueprint $table){
           $table->dropForeign(['curriculum_id']);
        });
        Schema::dropIfExists('references');
    }
}

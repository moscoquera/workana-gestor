<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curriculum_id');
            $table->string('company');
            $table->string('boss');
            $table->string('phone');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('retirement');
            $table->string('functions_in_charge');
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
        Schema::table('experiences',function (Blueprint $table){
           $table->dropForeign(['curriculum_id']);
        });

        Schema::dropIfExists('experiences');
    }
}

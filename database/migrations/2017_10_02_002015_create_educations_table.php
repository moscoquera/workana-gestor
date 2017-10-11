<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curriculum_id');
            $table->string('course_name');
            $table->string('institution');
            $table->date('completion_year');
            $table->unsignedInteger('type_id');
            $table->timestamps();

            $table->foreign('curriculum_id')->references('id')->on('curriculums');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educations',function (Blueprint $table){
            $table->dropForeign(['curriculum_id']);
            $table->dropForeign(['type_id']);
        });
        Schema::dropIfExists('educations');
    }
}

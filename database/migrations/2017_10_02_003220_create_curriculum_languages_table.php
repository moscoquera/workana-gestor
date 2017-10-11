<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_language', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id');
            $table->unsignedInteger('language_id');
            $table->decimal('writing');
            $table->decimal('reading');
            $table->decimal('speaking');
            $table->decimal('listening');
            $table->timestamps();

            $table->foreign('curriculum_id')->references('id')->on('curriculums');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_language',function (Blueprint $table ){
            $table->dropForeign(['curriculum_id']);
            $table->dropForeign(['language_id']);
        });

        Schema::dropIfExists('curriculum_languages');
    }
}

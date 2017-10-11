<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum_skill', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id');
            $table->unsignedInteger('skill_id');
            $table->decimal('experience');
            $table->timestamps();

            $table->foreign('curriculum_id')->references('id')->on('curriculums');
            $table->foreign('skill_id')->references('id')->on('skills');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_skill',function(Blueprint $table){
            $table->dropForeign(['curriculum_id']);
            $table->dropForeign(['skill_id']);
        });

        Schema::dropIfExists('curriculum_skills');
    }
}

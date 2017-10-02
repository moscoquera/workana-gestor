<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->char('sex',1);
            $table->date('date_of_birth');
            $table->string('document');
            $table->unsignedInteger('birth_city_id');
            $table->unsignedInteger('birth_dep_id');
            $table->unsignedInteger('nationality');
            $table->string('current_address',1024);
            $table->unsignedInteger('current_dep_id');
            $table->unsignedInteger('current_city_id');
            $table->unsignedInteger('current_country_id');
            $table->string('phone');
            $table->string('mobile');
            $table->unsignedInteger('profession_id');
            $table->unsignedInteger('company_id');
            $table->string('resume',2014);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('birth_city_id')->references('id')->on('cities');
            $table->foreign('birth_dep_id')->references('id')->on('departments');
            $table->foreign('nationality')->references('id')->on('countries');

            $table->foreign('current_city_id')->references('id')->on('cities');
            $table->foreign('current_dep_id')->references('id')->on('departments');
            $table->foreign('current_country_id')->references('id')->on('countries');

            $table->foreign('profession_id')->references('id')->on('professions');
            $table->foreign('company_id')->references('id')->on('companies');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculums',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['birth_city_id']);
            $table->dropForeign(['birth_dep_id']);
            $table->dropForeign(['nationality']);

            $table->dropForeign(['current_city_id']);
            $table->dropForeign(['current_dep_id']);
            $table->dropForeign(['current_country_id']);

            $table->dropForeign(['profession_id']);
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('Curriculum');
    }
}

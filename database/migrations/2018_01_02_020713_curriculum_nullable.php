<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurriculumNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums',function (Blueprint $table){
            $table->unsignedInteger('birth_city_id')->nullable()->change();
            $table->unsignedInteger('birth_dep_id')->nullable()->change();
            $table->string('resume',2014)->nullable()->change();
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
            $table->unsignedInteger('birth_city_id')->change();
            $table->unsignedInteger('birth_dep_id')->change();
            $table->string('resume',2014)->change();
        });
    }
}

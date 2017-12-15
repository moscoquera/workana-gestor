<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies',function (Blueprint $table){

            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::table('companies',function (Blueprint $table){

            $table->dropForeign(['department_id']);
            $table->dropForeign(['city_id']);

            $table->dropColumn('department_id');
            $table->dropColumn('city_id');


        });
    }
}

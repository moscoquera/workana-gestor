<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCompanyCurriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums',function (Blueprint $table){
            $table->dropForeign('curriculums_company_id_foreign');
           $table->dropColumn('company_id');
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
            $table->unsignedInteger('company_id');
        });
    }
}

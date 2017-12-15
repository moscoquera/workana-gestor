<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCurriculumEducations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educations',function (Blueprint $table){

            $table->dropColumn('institution');
            $table->unsignedInteger('educational_institution_id')->nullable();
            $table->foreign('educational_institution_id')->references('id')->on('educational_institutions');

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

            $table->foreign(['educational_institution_id']);
            $table->dropColumn('educational_institution_id');

            $table->text('institution',250)->nullable();

        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMoreFieldsToVisits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits',function (Blueprint $table){
           $table->unsignedInteger('result_id')->nullable();
           $table->date('next_visit')->nullable();
           $table->unsignedInteger('subject_id')->nullable();
           $table->text('attachments',4096)->nullable();

           $table->foreign('result_id')->references('id')->on('types');
           $table->foreign('subject_id')->references('id')->on('types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits',function (Blueprint $table){
            $table->foreign(['result_id']);
            $table->foreign(['subject_id']);

            $table->dropColumn('result_id');
            $table->dropColumn('next');
            $table->dropColumn('subject_id');
            $table->dropColumn('attachments');



        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisitsEventsSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits',function (Blueprint $table){
           $table->softDeletes();
        });

        Schema::table('events',function (Blueprint $table){
            $table->softDeletes();
        });

        Schema::table('attendances',function (Blueprint $table){
            $table->softDeletes();
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
            $table->dropSoftDeletes();
        });

        Schema::table('events',function (Blueprint $table){
            $table->dropSoftDeletes();
        });


        Schema::table('attendances',function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
}

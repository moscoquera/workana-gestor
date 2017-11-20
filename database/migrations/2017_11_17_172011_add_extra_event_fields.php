<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraEventFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events',function (Blueprint $table){
           $table->boolean('controlled')->default(false);
           $table->string('place_name',255)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events',function (Blueprint $table){
            $table->dropColumn('controlled');
            $table->dropColumn('place_name');
        });
    }
}

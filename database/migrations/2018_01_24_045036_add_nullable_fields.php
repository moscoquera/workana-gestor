<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events',function (Blueprint $table){
           $table->longText('observations')->nullable()->change();
        });

        Schema::table('visits',function (Blueprint $table){
           $table->text('address',255)->nullable()->change();
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
            $table->longText('observations')->change();
        });

        Schema::table('visits',function (Blueprint $table){
            $table->text('address',255)->change();
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventExtraFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events',function (Blueprint $table){
                $table->unsignedInteger('type_id');
                $table->foreign('type_id')->references('id')->on('types');
                $table->text('observations',2000)->change();
                $table->dropColumn('levels');
                $table->unsignedInteger('status_id');
                $table->foreign('status_id')->references('id')->on('types');
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
            $table->dropForeign('type_id');
            $table->dropColumn('type_id');
            $table->drdropColumnop('observations');
            $table->text('levels');
            $table->dropForeign('status_id');
            $table->dropColumn('status_id');
        });
    }
}

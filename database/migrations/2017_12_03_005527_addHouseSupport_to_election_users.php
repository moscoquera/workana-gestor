<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHouseSupportToElectionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('election_users',function (Blueprint $table) {
            $table->boolean('house_support');
            $table->renameColumn('type_id','activity_id');
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
        Schema::table('election_users',function (Blueprint $table) {
            $table->dropColumn('house_support');
            $table->renameColumn('activity_id','type_id');
            $table->dropSoftDeletes();
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserLeaderElectionData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function (Blueprint $table){
            $table->unsignedInteger('leader_id')->nullable();
            $table->string('election_address',1024)->nullable();
            $table->unsignedInteger('election_dep_id')->nullable();
            $table->unsignedInteger('election_city_id')->nullable();

            $table->foreign('election_city_id')->references('id')->on('cities');
            $table->foreign('election_dep_id')->references('id')->on('departments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function (Blueprint $table){
            $table->dropForeign(['election_city_id']);
            $table->dropForeign(['election_dep_id']);

            $table->dropColumn('leader_id');
            $table->dropColumn('election_address');
            $table->dropColumn('election_dep_id');
            $table->dropColumn('election_city_id');


        });
    }
}

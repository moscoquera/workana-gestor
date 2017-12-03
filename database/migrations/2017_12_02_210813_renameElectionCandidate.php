<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameElectionCandidate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('election_candidate','election_candidates');
        Schema::table('election_candidates',function (Blueprint $table){
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('election_candidates',function (Blueprint $table){
            $table->dropPrimary();
            $table->dropColumn('id');
        });
        Schema::rename('election_candidates','election_candidate');
    }
}

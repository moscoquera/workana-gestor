<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCityElectionCandidatesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('city_election_candidates', function (Blueprint $table) {
            $table->renameColumn('election_candidate_id','candidacy_id');
            $table->unsignedInteger('inscribed')->nullable()->default(0);
	        $table->unsignedInteger('registered')->nullable()->default(0);
	        $table->text('effectivity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('city_election_candidates', function (Blueprint $table) {
	        $table->dropColumn('inscribed','registered','effectivity');
	        $table->renameColumn('candidacy_id','election_candidate_id');
        });
    }
}

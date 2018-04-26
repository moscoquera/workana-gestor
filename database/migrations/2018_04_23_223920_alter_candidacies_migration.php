<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCandidaciesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('election_candidates',function(Blueprint $table){
    		//$table->dropForeign('election_candidates_election_id_foreign');
		    //$table->dropIndex('election_candidates_election_id_foreign_idx');
		    $table->dropForeign(['election_id']);
		    $table->dropColumn('election_id','elected');

	    });
        Schema::rename('election_candidates','candidacies');
        Schema::table('candidacies',function (Blueprint $table){
        	$table->date('election_date')->nullable();
        	$table->unsignedInteger('party_votes')->default(0);
        	$table->unsignedInteger('party_number')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('candidacies',function (Blueprint $table){
		    $table->dropColumn('election_date','party_votes','party_number');

	    });
	    Schema::rename('candidacies','election_candidates');
	    Schema::table('election_candidates',function(Blueprint $table){

		    $table->unsignedInteger('election_id')->nullable();
		    $table->boolean('elected')->default(false);
		    $table->foreign('election_id')->references('id')->on('elections');

	    });
    }
}

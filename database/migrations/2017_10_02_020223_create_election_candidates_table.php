<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_candidate', function (Blueprint $table) {
            $table->unsignedInteger('election_id');
            $table->unsignedInteger('candidate_id');
            $table->integer('proyected_votes');
            $table->integer('gotten_votes');
            $table->boolean('elected');
            $table->string('observation',1024);

            $table->timestamps();

            $table->foreign('election_id')->references('id')->on('elections');
            $table->foreign('candidate_id')->references('id')->on('candidates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('election_candidate',function (Blueprint $table){
            $table->dropForeign(['election_id']);
            $table->dropForeign(['candidate_id']);

        });

        Schema::dropIfExists('election_candidates');
    }
}

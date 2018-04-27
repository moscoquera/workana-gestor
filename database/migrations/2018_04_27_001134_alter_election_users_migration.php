<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterElectionUsersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('election_users', function (Blueprint $table) {
            $table->dropForeign('election_user_election_id_foreign');
            $table->dropForeign('election_user_type_id_foreign');

            $table->renameColumn('proyected_votes','zoned');
	        $table->renameColumn('registered_votes','registered');
	        $table->renameColumn('controlled_votes','controlled');
	        $table->text('bonuses')->nullable();
	        $table->unsignedInteger('candidacy_id')->nullable();

	        $table->unsignedInteger('payroll')->nullable()->change();
	        $table->dropColumn('election_id','identified_votes','transport_cost','refreshments','house_support',
		        'activity_id');
	        $table->foreign('candidacy_id')->references('id')->on('candidacies');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('election_users', function (Blueprint $table) {
	        $table->unsignedInteger('election_id')->nullable();
	        $table->unsignedInteger('identified_votes')->nullable();
	        $table->unsignedInteger('transport_cost')->nullable();
	        $table->unsignedInteger('refreshments')->nullable();
	        $table->unsignedInteger('house_support')->nullable();
	        $table->unsignedInteger('activity_id')->nullable();


	        $table->dropForeign(['candidacy_id']);

	        $table->renameColumn('zoned','proyected_votes');
	        $table->renameColumn('registered','registered_votes');
	        $table->renameColumn('controlled','controlled_votes');
	        $table->dropColumn('bonuses','candidacy_id');

	        $table->index('election_id','election_user_election_id_foreign');
	        $table->foreign('election_id','election_user_election_id_foreign')
	              ->references('id')->on('references');
			$table->foreign('activity_id','election_user_type_id_foreign')
			      ->references('id')->on('types');
        });
    }
}

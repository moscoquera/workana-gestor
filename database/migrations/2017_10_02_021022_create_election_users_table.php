<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('election_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('election_id');
            $table->unsignedInteger('user_id');
            $table->integer('proyected_votes');
            $table->integer('registered_votes');
            $table->integer('controlled_votes');
            $table->integer('identified_votes');
            $table->boolean('transport_requeriment');
            $table->decimal('transport_cost');
            $table->integer('refreshments');
            $table->boolean('kit');
            $table->boolean('payroll');
            $table->decimal('payment');
            $table->integer('number_of_payments');
            $table->unsignedInteger('type_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('election_id')->references('id')->on('elections');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('election_user',function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['election_id']);
            $table->dropForeign(['type_id']);
        });

        Schema::dropIfExists('election_users');
    }
}

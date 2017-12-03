<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateElectionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('election_user','election_users');
        Schema::table('election_users',function (Blueprint $table){
            $table->integer('proyected_votes')->nullable()->change();
            $table->integer('registered_votes')->nullable()->change();
            $table->integer('controlled_votes')->nullable()->change();
            $table->integer('identified_votes')->nullable()->change();
            $table->text('transport_requeriment',2048)->nullable()->change();
            $table->decimal('transport_cost')->nullable()->change();
            $table->integer('refreshments')->nullable()->change();
            $table->boolean('kit')->nullable()->change();
            $table->boolean('payroll')->nullable()->change();
            $table->decimal('payment')->nullable()->change();
            $table->integer('number_of_payments')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('election_users',function (Blueprint $table){
            $table->integer('proyected_votes')->change();
            $table->integer('registered_votes')->change();
            $table->integer('controlled_votes')->change();
            $table->integer('identified_votes')->change();
            $table->boolean('transport_requeriment')->change();
            $table->decimal('transport_cost')->change();
            $table->integer('refreshments')->change();
            $table->boolean('kit')->change();
            $table->boolean('payroll')->change();
            $table->decimal('payment')->change();
            $table->integer('number_of_payments')->change();
        });

        Schema::rename('election_users','election_user');

    }
}

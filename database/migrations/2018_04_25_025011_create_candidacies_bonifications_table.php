<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaciesBonificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidacies_bonifications', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('candidacy_id');
            $table->unsignedInteger('bonuses');
            $table->unsignedInteger('bonified');
	        $table->unsignedInteger('rosted');
	        $table->unsignedInteger('workers');

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
        Schema::dropIfExists('candidacies_bonifications');
    }
}

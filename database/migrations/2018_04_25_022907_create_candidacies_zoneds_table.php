<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaciesZonedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidacies_zoneds', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('candidacy_id');
            $table->unsignedInteger('total');
	        $table->unsignedInteger('without_incidence');
	        $table->unsignedInteger('with_incidence');
	        $table->unsignedInteger('proyected');
	        $table->float('percentage');

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
        Schema::dropIfExists('candidacies_zoneds');
    }
}

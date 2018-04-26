<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaciesHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidacies_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			$table->unsignedInteger('candidacy_id');
			$table->unsignedInteger('support_house_id');
			$table->unsignedInteger('registered');
			$table->unsignedInteger('controlled');
			$table->unsignedInteger('manual');

	        $table->foreign('candidacy_id')->references('id')->on('candidacies');
	        $table->foreign('support_house_id')->references('id')->on('support_houses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidacies_houses');
    }
}

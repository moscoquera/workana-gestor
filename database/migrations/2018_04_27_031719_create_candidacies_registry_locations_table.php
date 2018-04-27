<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaciesRegistryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidacies_registry_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('candidacy_id');
            $table->string('poll_place',500);
	        $table->unsignedInteger('votes')->nullable()->default(0);
	        $table->unsignedInteger('inscribed')->nullable()->default(0);
	        $table->unsignedInteger('registered')->nullable()->default(0);
	        $table->text('effectivity')->nullable();

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
        Schema::dropIfExists('candidacies_registry_locations');
    }
}

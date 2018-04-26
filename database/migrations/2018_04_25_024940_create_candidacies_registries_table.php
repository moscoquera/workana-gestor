<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaciesRegistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidacies_registries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('candidacy_id');
            $table->unsignedInteger('registered');
            $table->unsignedInteger('controlled');
            $table->unsignedInteger('manual');
            $table->unsignedInteger('precounted');
            $table->unsignedInteger('final');
            $table->text('effectivity')->nullable();
            $table->unsignedInteger('visited');
            $table->unsignedInteger('trained');

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
        Schema::dropIfExists('candidacies_registries');
    }
}

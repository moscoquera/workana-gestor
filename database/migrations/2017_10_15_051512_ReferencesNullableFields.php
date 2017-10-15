<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReferencesNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('references', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id')->nullable()->change();
            $table->string('type',1)->nullable()->change();
            $table->string('fullname')->nullable()->change();
            $table->string('profession')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('references', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id')->change();
            $table->string('type',1)->change();
            $table->string('fullname')->change();
            $table->string('profession')->change();
            $table->string('phone')->change();
        });
    }
}

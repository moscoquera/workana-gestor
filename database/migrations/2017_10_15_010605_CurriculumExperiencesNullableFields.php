<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurriculumExperiencesNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id')->nullable()->change();
            $table->string('company')->nullable()->change();
            $table->string('boss')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->string('retirement')->nullable()->change();
            $table->string('functions_in_charge')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id')->change();
            $table->string('company')->change();
            $table->string('boss')->change();
            $table->string('phone')->change();
            $table->date('start_date')->change();
            $table->date('end_date')->change();
            $table->string('retirement')->change();
            $table->string('functions_in_charge')->change();

        });
    }
}

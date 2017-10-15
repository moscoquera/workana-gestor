<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurriculumEducationsNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id')->nullable()->change();
            $table->string('course_name')->nullable()->change();
            $table->string('institution')->nullable()->change();
            $table->date('completion_year')->nullable()->change();
            $table->unsignedInteger('type_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->unsignedInteger('curriculum_id')->change();
            $table->string('course_name')->change();
            $table->string('institution')->change();
            $table->date('completion_year')->change();
            $table->unsignedInteger('type_id')->change();

        });
    }
}

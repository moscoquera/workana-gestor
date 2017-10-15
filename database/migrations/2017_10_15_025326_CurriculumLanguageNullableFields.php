<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurriculumLanguageNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_language', function (Blueprint $table) {
            $table->decimal('writing')->nullable()->change();
            $table->decimal('reading')->nullable()->change();
            $table->decimal('speaking')->nullable()->change();
            $table->decimal('listening')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_language', function (Blueprint $table) {
            $table->decimal('writing')->change();
            $table->decimal('reading')->change();
            $table->decimal('speaking')->change();
            $table->decimal('listening')->change();

        });
    }
}

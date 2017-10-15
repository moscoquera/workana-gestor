<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurriculumLanguageFieldsTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_language', function (Blueprint $table) {
            $table->integer('writing')->nullable()->change();
            $table->integer('reading')->nullable()->change();
            $table->integer('speaking')->nullable()->change();
            $table->integer('listening')->nullable()->change();

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLanguageProficencyMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_language',function(Blueprint $table){
            $table->string('writing',1)->change();
            $table->string('reading',1)->change();
            $table->string('speaking',1)->change();
            $table->string('listening',1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_language',function(Blueprint $table){
            $table->decimal('writing',1)->change();
            $table->decimal('reading',1)->change();
            $table->decimal('speaking',1)->change();
            $table->decimal('listening',1)->change();
        });
    }
}

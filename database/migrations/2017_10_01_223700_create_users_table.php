<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('rol_id');
            $table->string('photo')->nullable();
            $table->decimal('rating')->nullable();
            $table->unsignedInteger('level_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('rols');
            $table->foreign('level_id')->references('id')->on('levels');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function (Blueprint $table){
            $table->dropForeign(['rol_id']);
            $table->dropForeign(['level_id']);
            $table->dropForeign(['curriculum_id']);
        });
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsernameUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function (Blueprint $table){
            $table->string('username',50)->default('tmp');
        });

        DB::update("update users set username = email where username='tmp'");
        Schema::table('users',function (Blueprint $table) {
            $table->string('username',50)->unique()->change();
        });

        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
}

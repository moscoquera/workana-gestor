<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCandidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidates',function (Blueprint $table){
        	$table->renameColumn('name','first_name');
        	$table->string('document',20);
        	$table->string('last_name',100);
        	$table->unsignedInteger('department_id')->nullable();
        	$table->unsignedInteger('city_id')->nullable();
        	$table->string('address',250)->nullable();
        	$table->string('phone',30)->nullable();
        	$table->string('phone_alt',30)->nullable();
        	$table->string('photo',250)->nullable();
        	$table->unsignedInteger('profession_id')->nullable();
        	$table->date('enter_date')->nullable();

	        $table->foreign('department_id')->references('id')->on('departments');
        	$table->foreign('city_id')->references('id')->on('cities');
	        $table->foreign('profession_id')->references('id')->on('professions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('candidates',function (Blueprint $table){

		    $table->dropForeign(['department_id']);
		    $table->dropForeign(['city_id']);
		    $table->dropForeign(['profession_id']);

		    $table->renameColumn('first_name','name');
		    $table->dropColumn('document','last_name','department_id','city_id','address','phone','phone_alt','photo','profession_id','enter_date');
	    });
    }
}

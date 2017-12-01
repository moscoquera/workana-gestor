<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MoveCurriculumFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function (Blueprint $table){
            $table->char('sex',1)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedInteger('nationality_id')->nullable();
            $table->string('current_address',1024)->nullable();
            $table->unsignedInteger('current_dep_id')->nullable();
            $table->unsignedInteger('current_city_id')->nullable();
            $table->unsignedInteger('current_country_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedInteger('profession_id')->nullable();


            $table->foreign('nationality_id')->references('id')->on('countries');
            $table->foreign('current_city_id')->references('id')->on('cities');
            $table->foreign('current_dep_id')->references('id')->on('departments');
            $table->foreign('current_country_id')->references('id')->on('countries');
            $table->foreign('profession_id')->references('id')->on('professions');

        });


        DB::table('users')->join('curriculums','users.id','=','curriculums.user_id')->update([
            'users.sex'=>DB::raw("`curriculums`.`sex`"),
            'users.date_of_birth'=>DB::raw("`curriculums`.`date_of_birth`"),
            'users.nationality_id'=>DB::raw("`curriculums`.`nationality_id`"),
            'users.current_address'=>DB::raw("`curriculums`.`current_address`"),
            'users.current_dep_id'=>DB::raw("`curriculums`.`current_dep_id`"),
            'users.current_city_id'=>DB::raw("`curriculums`.`current_city_id`"),
            'users.current_country_id'=>DB::raw("`curriculums`.`current_country_id`"),
            'users.phone'=>DB::raw("`curriculums`.`phone`"),
            'users.mobile'=>DB::raw("`curriculums`.`mobile`"),
            'users.profession_id'=>DB::raw("`curriculums`.`profession_id`"),

        ]);

        Schema::table('curriculums',function (Blueprint $table){

            $table->dropForeign(['nationality_id']);
            $table->dropForeign(['current_city_id']);
            $table->dropForeign(['current_dep_id']);
            $table->dropForeign(['current_country_id']);
            $table->dropForeign(['profession_id']);


            $table->dropColumn('sex');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('nationality_id');
            $table->dropColumn('current_address');
            $table->dropColumn('current_dep_id');
            $table->dropColumn('current_city_id');
            $table->dropColumn('current_country_id');
            $table->dropColumn('phone');
            $table->dropColumn('mobile');
            $table->dropColumn('profession_id');



        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculums',function (Blueprint $table){
            $table->char('sex',1)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedInteger('nationality_id')->nullable();
            $table->string('current_address',1024)->nullable();
            $table->unsignedInteger('current_dep_id')->nullable();
            $table->unsignedInteger('current_city_id')->nullable();
            $table->unsignedInteger('current_country_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedInteger('profession_id')->nullable();


            $table->foreign('nationality_id')->references('id')->on('countries');
            $table->foreign('current_city_id')->references('id')->on('cities');
            $table->foreign('current_dep_id')->references('id')->on('departments');
            $table->foreign('current_country_id')->references('id')->on('countries');
            $table->foreign('profession_id')->references('id')->on('professions');

        });


        DB::table('curriculums')->join('users','users.id','=','curriculums.user_id')->update([
            'curriculums.sex'=>DB::raw("`users`.`sex`"),
            'curriculums.date_of_birth'=>DB::raw("`users`.`date_of_birth`"),
            'curriculums.nationality_id'=>DB::raw("`users`.`nationality_id`"),
            'curriculums.current_address'=>DB::raw("`users`.`current_address`"),
            'curriculums.current_dep_id'=>DB::raw("`users`.`current_dep_id`"),
            'curriculums.current_city_id'=>DB::raw("`users`.`current_city_id`"),
            'curriculums.current_country_id'=>DB::raw("`users`.`current_country_id`"),
            'curriculums.phone'=>DB::raw("`users`.`phone`"),
            'curriculums.mobile'=>DB::raw("`users`.`mobile`"),
            'curriculums.profession_id'=>DB::raw("`users`.`profession_id`"),

        ]);

        Schema::table('curriculums',function (Blueprint $table){
            $table->text('sex',1)->change();
            $table->date('date_of_birth')->change();
            $table->unsignedInteger('nationality_id')->change();
            $table->string('current_address',1024)->change();
            $table->unsignedInteger('current_dep_id')->change();
            $table->unsignedInteger('current_city_id')->change();
            $table->unsignedInteger('current_country_id')->change();
            $table->string('phone')->change();
            $table->string('mobile')->change();
            $table->unsignedInteger('profession_id')->change();

        });

        Schema::table('users',function (Blueprint $table){

            $table->dropForeign(['nationality_id']);
            $table->dropForeign(['current_city_id']);
            $table->dropForeign(['current_dep_id']);
            $table->dropForeign(['current_country_id']);
            $table->dropForeign(['profession_id']);


            $table->dropColumn('sex');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('nationality_id');
            $table->dropColumn('current_address');
            $table->dropColumn('current_dep_id');
            $table->dropColumn('current_city_id');
            $table->dropColumn('current_country_id');
            $table->dropColumn('phone');
            $table->dropColumn('mobile');
            $table->dropColumn('profession_id');


        });

    }
}

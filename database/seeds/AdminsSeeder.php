<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name'=>'admin',
            'last_name'=>'',
            'email'=>'admin@admin.com',
            'password'=>  bcrypt('admin'),
            'rol_id'=>1
        ]);
    }
}

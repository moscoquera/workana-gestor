<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert([
            ['id'=>1, 'name' => 'Administrador'],
            ['id'=>2, 'name' => 'normal'],
        ]);
    }
}

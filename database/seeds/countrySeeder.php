<?php

use Illuminate\Database\Seeder;

class countrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name'=>'Colombia'
        ]);
    }
}

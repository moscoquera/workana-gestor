<?php

use Illuminate\Database\Seeder;

class CompaniesSectorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'name'=>'Público',
                'type'=>'company_sector',
                'order'=>0
            ],
            [
                'name'=>'Privado',
                'type'=>'company_sector',
                'order'=>1
            ]
        ]);
    }
}

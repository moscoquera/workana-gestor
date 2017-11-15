<?php

use Illuminate\Database\Seeder;

class ContractTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ContractType::insert([
            [
                'name'=>'Prestación de servicios',
                'type'=>'contract',
                'order'=>0,
            ]
        ]);
    }
}

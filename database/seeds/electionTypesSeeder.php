<?php

use Illuminate\Database\Seeder;


class electionTypesSeeder extends Seeder
{
    public function run()
    {

        \App\Models\ElectionType::insert([
            [
                'name'=>'Concejo',
                'type'=>'election',
                'order'=>0,
            ]
        ]);

        \App\Models\ElectionType::insert([
            [
                'name'=>'Alcaldia',
                'type'=>'election',
                'order'=>0,
            ]
        ]);

        \App\Models\ElectionType::insert([
            [
                'name'=>'Diputado',
                'type'=>'election',
                'order'=>0,
            ]
        ]);

        \App\Models\ElectionType::insert([
            [
                'name'=>'Senador',
                'type'=>'election',
                'order'=>0,
            ]
        ]);

    }
}

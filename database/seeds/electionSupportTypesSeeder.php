<?php

use Illuminate\Database\Seeder;

class electionSupportTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ElectionSupportType::insert([
            [
                'name'=>'Testigo',
                'type'=>'election-support',
                'order'=>0,
            ]
        ]);

        \App\Models\ElectionSupportType::insert([
            [
                'name'=>'Coordinador',
                'type'=>'election-support',
                'order'=>0,
            ]
        ]);

        \App\Models\ElectionSupportType::insert([
            [
                'name'=>'Concentracion',
                'type'=>'election-support',
                'order'=>0,
            ]
        ]);

        \App\Models\ElectionSupportType::insert([
            [
                'name'=>'Jurado',
                'type'=>'election-support',
                'order'=>0,
            ]
        ]);

    }
}

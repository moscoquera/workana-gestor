<?php

use Illuminate\Database\Seeder;

class visitStatutesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\VisitStatus::insert([
            'name'=>'Pendiente',
            'type'=>'visit-status',
            'order'=>0,
        ]);

        \App\Models\VisitStatus::insert([
            'name'=>'En proceso',
            'type'=>'visit-status',
            'order'=>0,
        ]);

        \App\Models\VisitStatus::insert([
            'name'=>'Realizado',
            'type'=>'visit-status',
            'order'=>0,
        ]);

        \App\Models\VisitStatus::insert([
            'name'=>'Anulado',
            'type'=>'visit-status',
            'order'=>0,
        ]);
    }
}

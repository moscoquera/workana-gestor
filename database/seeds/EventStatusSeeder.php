<?php

use Illuminate\Database\Seeder;

class EventStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EventStatus::insert([
            [
                'name'=>'Activo',
                'type'=>'event_status',
                'order'=>0,
            ],
            [
                'name'=>'Cancelado',
                'type'=>'event_status',
                'order'=>1,
            ],
            [
                'name'=>'Ejecutado',
                'type'=>'event_status',
                'order'=>2,
            ]
        ]);
    }
}

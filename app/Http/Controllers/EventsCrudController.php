<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class EventsCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute('events');
        $this->crud->setEntityNameStrings('evento', 'eventos');


        $this->crud->addColumns([
            [
                'label'=>'Consecutivo',
                'name'=>'id',

            ],
            [
                'name'=>'dateandtime',
                'label'=>'Fecha y hora',
            ],
            [
                'name'=>'name',
                'label'=>'Nombre'
            ],
            [
                'name'=>'address',
                'label'=>'Lugar del evento'
            ],
            [

            ]
        ]);

    }
}

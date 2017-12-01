<?php

namespace App\Http\Controllers;

use App\Http\Requests\visitCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class visitsCrudController extends CrudController
{


    public function setup()
    {
        $this->crud->setModel('App\Models\Visit');
        $this->crud->setRoute('visits');
        $this->crud->setEntityNameStrings('visita', 'visitas');

        $this->crud->child_resource_included = ['angular'=>false,'select' => true, 'number' => false];
        $this->crud->child_resource_initialized = ['select' => false, 'number' => false];


        $this->crud->addColumns([
            [
                'label'=>'ID',
                'name'=>'id',
            ],
            [
                'label'=>'Fecha y hora',
                'name'=>'dateandtime',
            ],
            [
                'label'=>'Lugar',
                'name'=>'address',
            ],
            [
                'label'=>'Descripción',
                'name'=>'description'
            ]

        ]);

        $this->crud->addFields([
            [
                'label'=>'Fecha y hora',
                'name'=>'dateandtime',
                'type'=>'datetime_picker'
            ],
            [
                'label'=>'Lugar',
                'name'=>'address',
                'type'=>'text'
            ],
            [
                'label'=>'Descripción',
                'name'=>'description',
                'type'=>'textarea'
            ],
            [
                'label'=>'Comentarios',
                'name'=>'comments',
                'type'=>'textarea'
            ],
            [
                'name' => 'attendance',
                'label' => 'Asistentes',
                'type' => 'child',
                'entity_singular' => 'asistente', // used on the "Add X" button
                'columns' => [
                    [
                        'label' => "Nombre",
                        'type' => "child_select",
                        'name' => 'attende_id', // the column that contains the ID of that connected entity
                        'entity' => 'attende', // the method that defines the relationship in your Model
                        'attribute' => "fullname", // foreign key attribute that is shown to user
                        'model' => "App\Models\PublicUser", // foreign key model

                    ],

                ],
                'max' => 100, // maximum rows allowed in the table
                'min' => 1 // minimum rows allowed in the table
            ]

        ]);

    }


    public function store(visitCrudRequest  $request){
        return $this->storeCrud($request);
    }


    public function update(visitCrudRequest  $request){
        return $this->updateCrud($request);
    }

}

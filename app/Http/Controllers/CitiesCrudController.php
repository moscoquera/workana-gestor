<?php

namespace App\Http\Controllers;

use App\Http\Requests\Geo\CityCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CitiesCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\City');
        $this->crud->setRoute('cities');
        $this->crud->setEntityNameStrings('ciudad','ciudades');

        $this->crud->addColumns([
            ['name'=>'id',
                'label'=>'ID'
            ],
            [
                'name'=>'name',
                'label'=>'Nombre'
            ],
            [
                'name'=>'department_id',
                'label'=>'departamento',
                'type'=>'select',
                'entity'=>'department',
                'attribute'=>'name',
                'model'=>'App\Models\Department'
            ]
        ]);

        $this->crud->addFields(
            [
                [
                    'name'=>'name',
                    'label'=>'Nombre'
                ],
                [
                    'name'=>'department_id',
                    'label'=>'departamento',
                    'type'=>'select2',
                    'entity'=>'department',
                    'attribute'=>'name',
                    'model'=>'App\Models\Department'
                ]
            ]
        );
    }


    public function store(CityCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(CityCrudRequest $request){
        return $this->updateCrud($request);
    }
}

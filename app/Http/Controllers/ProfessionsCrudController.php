<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessionCrudRequest;
use App\Models\Education;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class ProfessionsCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\Profession');
        $this->crud->setEntityNameStrings('profesión','profesiones');
        $this->crud->setRoute('professions');

        $this->crud->addColumns([
            ['name'=>'id',
                'label'=>'ID'],
            [
                'name'=>'name',
                'label'=>'Nombre'
            ],
            [
                'name'=>'type_id',
                'label'=>'Nivel educativo',
                'type'=>'select',
                'attribute'=>'name',
                'model'=>Education::class,
                'entity'=>'type',
            ]
        ]);

        $this->crud->addFields(
            [
                [
                    'name'=>'name',
                    'label'=>'Nombre'
                ],
                [
                    'name'=>'type_id',
                    'label'=>'Nivel educativo',
                    'type'=>'select2',
                    'attribute'=>'name',
                    'model'=>Education::class,
                    'entity'=>'type',
                ]
            ]
        );



    }

    public function update(ProfessionCrudRequest $request){
        return $this->updateCrud($request);
    }


    public function store(ProfessionCrudRequest $request){
        return $this->storeCrud($request);
    }
}

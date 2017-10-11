<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessionCrudRequest;
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
            ]
        ]);

        $this->crud->addField([
            'name'=>'name',
            'label'=>'Nombre'
        ]);



    }

    public function update(ProfessionCrudRequest $request){
        return $this->updateCrud($request);
    }


    public function store(ProfessionCrudRequest $request){
        return $this->storeCrud($request);
    }
}

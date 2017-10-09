<?php

namespace App\Http\Controllers;

use App\Http\Requests\Geo\DepartmentCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class DepartmentsCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\Department');
        $this->crud->setRoute('departments');
        $this->crud->setEntityNameStrings('departamento','departamentos');

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


    public function store(DepartmentCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(DepartmentCrudRequest $request){
        return $this->updateCrud($request);
    }

}

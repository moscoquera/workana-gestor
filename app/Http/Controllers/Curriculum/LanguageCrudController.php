<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Requests\Curriculum\LanguageCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\Language');
        $this->crud->setRoute('languages');
        $this->crud->setEntityNameStrings('idioma','idiomas');

        $this->crud->addColumns([
            [
              'name'=>'id',
              'label'=>'ID'
            ],
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

    public function store(LanguageCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(LanguageCrudRequest $request){
        return $this->updateCrud($request);
    }



}

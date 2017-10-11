<?php

namespace App\Http\Controllers;

use App\Http\Requests\Geo\CountryCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Http\Request;

class CountriesCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setRoute('countries');
        $this->crud->setModel('App\Models\Country');
        $this->crud->setEntityNameStrings('país','paises');

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

    public function store(CountryCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(CountryCrudRequest $request){
        return $this->updateCrud($request);
    }

}

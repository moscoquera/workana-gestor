<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelCrudRequest;
use App\Models\Level;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class LevelCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel(Level::class);
        $this->crud->setRoute('levels');
        $this->crud->setEntityNameStrings('perfíl','perfiles');

        $this->crud->addColumns([
            [
                'label'=>'Etiqueta',
                'name'=>'slug'
            ],
            [
                'label'=>'Nombre',
                'name'=>'name'
            ],
        ]);

        $this->crud->addFields([
            [
                'label'=>'Etiqueta',
                'name'=>'slug',
                'type'=>'text',
            ],
            [
                'label'=>'Nombre',
                'name'=>'name',
                'type'=>'text',
            ]
        ]);

    }

    public function store(LevelCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(LevelCrudRequest $request){
        return $this->updateCrud($request);
    }

}

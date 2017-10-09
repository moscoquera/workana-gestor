<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Requests\Curriculum\SkillCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillCrudController extends CrudController
{


    public function setup()
    {
        $this->crud->setModel('App\Models\Skill');
        $this->crud->setRoute('skills');
        $this->crud->setEntityNameStrings('skill','skills');

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

    public function store(SkillCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(SkillCrudRequest $request){
        return $this->updateCrud($request);
    }

}

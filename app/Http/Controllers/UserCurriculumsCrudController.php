<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCurriculumsCrudController extends UserCrudController
{


    public function setup()
    {
        $this->crud->setModel('App\Models\PublicUser');
        $this->crud->setRoute('curriculums');
        $this->crud->setEntityNameStrings('curriculum', 'curriculums');
        $this->crud->allowAccess('list');
        $this->crud->denyAccess(['update','delete','create']);

        $this->crud->setColumns([
            [
                'label' => '# Documento',
                'name' => 'username',
            ],
            [
                'label' => 'Nombres',
                'name' => 'first_name'
            ],
            [
                'label' => 'Apellidos',
                'name' => 'last_name'
            ],
            'email',
            [
                'label' => 'Perfíl',
                'name' => 'level',
                'type' => 'select',
                'entity' => 'level', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Level" // foreign key model
            ],
            [
                'label' => 'Profesión',
                'name' => 'profession',
                'type' => 'select',
                'entity' => 'profession',
                'attribute' => 'name',
                'model' => 'App.Models.Profession'
            ],
            [
                'label' => 'Líder',
                'name' => 'leader',
                'type' => 'select',
                'entity' => 'leader',
                'attribute' => 'fullname',
                'model' => PublicUser::class,
            ]
        ]);


        $this->crud->addButtonFromModelFunction('line','curriculum','crudHasCurriculum','beginning');

    }

}

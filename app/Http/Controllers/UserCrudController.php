<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateUserCrudRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\Users\CreateUserCrudRequest;

class UserCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\PublicUser');
        $this->crud->setRoute('users');
        $this->crud->setEntityNameStrings('usuario','usuarios');

        $this->crud->setColumns([
            [
                'label'=>'# documento',
                'name'=>'username',
            ],
            [
                'label'=>'Nombres',
                'name'=>'first_name'
            ],
            [
                'label'=>'Apellidos',
                'name'=>'last_name'
            ],
            'email',
            [
                'label'=>'perfíl',
                'name'=>'level',
                'type'=>'select',
                'entity' => 'level', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Level" // foreign key model
            ]]);

        $this->crud->addFields(
            [
                [
                    'name'=>'username',
                    'label'=>'# de documento'
                ],
                [
                    'name'=>'first_name',
                    'label'=>'Nombres',
                ],
                [
                    'name'=>'last_name',
                    'label'=>'Apellidos',
                ],
                [
                    'label'=>'email',
                    'name'=>'email',
                    'hint'=>'opcional'
                ],
                [  // Select2
                    'label' => "Perfíl",
                    'type' => 'select2',
                    'name' => 'level_id', // the db column for the foreign key
                    'entity' => 'level', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'model' => "App\Models\Level" // foreign key model
                ]

            ]
        ,'both');




        $this->crud->addField([
            'fake'=>true,
            'name'=>'passwordchange',
            'label'=>'Cambiar contraseña',
            'type'=>'checkbox',

        ],'update');

        $this->crud->addField([
            'name'=>'password',
            'label'=>'Contraseña',
            'type'=>'password',

        ],'update');
        $this->crud->addField([
            'name'=>'password_confirmation',
            'fake'=>true,
            'label'=>'Confirmar contraseña',
            'type'=>'password',

        ],'update');

        $this->crud->addButtonFromModelFunction('line','curriculum','crudHasCurriculum','beginning');

    }


    public function store(CreateUserCrudRequest $request)
    {
        $request['password']=bcrypt($request['username']);
        $request['rol_id']=2;
        return parent::storeCrud($request);
    }

    public function update(UpdateUserCrudRequest $request)
    {
        if ($request->input('passwordchange')=="1" && $request->input('password')){
            $request['password']=bcrypt($request['password']);
        }else{
            unset($request['password']);
        }

        return parent::updateCrud($request);
    }


}

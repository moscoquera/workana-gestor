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
                'label'=>'Nombres',
                'name'=>'first_name'
            ],
            [
                'label'=>'Apellidos',
                'name'=>'last_name'
            ],
            [
            'label' => "Rol", // Table column heading
            'type' => "select",
            'name' => 'rol_id', // the column that contains the ID of that connected entity;
            'entity' => 'rol', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Rol", // foreign key model
        ],'email']);

        $this->crud->addFields(
            [
                [
                    'name'=>'first_name',
                    'label'=>'Nombres',
                ],
                [
                    'name'=>'last_name',
                    'label'=>'Apellidos',
                ],
                'email'

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

        ],'both');
        $this->crud->addField([
            'name'=>'password_confirmation',
            'fake'=>true,
            'label'=>'Confirmar contraseña',
            'type'=>'password',

        ],'both');


    }


    public function store(CreateUserCrudRequest $request)
    {
        $request['password']=bcrypt($request['password']);
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

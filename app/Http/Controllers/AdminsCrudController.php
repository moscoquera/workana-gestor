<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminsCrudRequest;
use App\Http\Requests\UpdateAdminsCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;



class AdminsCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\Admin');
        $this->crud->setRoute('admins');
        $this->crud->setEntityNameStrings('administrador','administradores');


        $this->crud->setColumns([
            [
                'label'=>'Nombres',
                'name'=>'first_name'
            ],
            [
                'label'=>'Apellidos',
                'name'=>'last_name'
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
                [
                    'name'=>'Email',
                    'label'=>'Email',

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

        ],'both');
        $this->crud->addField([
            'name'=>'password_confirmation',
            'fake'=>true,
            'label'=>'Confirmar contraseña',
            'type'=>'password',

        ],'both');

    }


    public function store(CreateAdminsCrudRequest $request){
        $request['username']=$request['email'];
        $request['password']=bcrypt($request['password']);
        $request['rol_id']=1;
        return parent::storeCrud($request);
    }


    public function update(UpdateAdminsCrudRequest $request){
        if ($request->input('passwordchange')=="1" && $request->input('password')){
            $request['password']=bcrypt($request['password']);
        }else{
            unset($request['password']);
        }

        return parent::updateCrud($request);
    }

}

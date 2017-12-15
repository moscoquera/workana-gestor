<?php

namespace App\Http\Controllers;

use App\Http\Requests\tempUserCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class tempUsersCrudController extends CrudController
{

    public function setup()
    {

        $this->crud->setModel('App\Models\TempUser');
        $this->crud->setRoute('tempusers');
        $this->crud->setEntityNameStrings('usuario externo', 'usuarios externos');


        $this->crud->addColumns([
            [
                'label'=>'ID',
                'name'=>'id'
            ],
            [
                'label'=>'Documento',
                'name'=>'document'
            ],
            [
                'label'=>'Nombres',
                'name'=>'first_name'
            ],
            [
                'label'=>'Apellidos',
                'name'=>'last_name'
            ],
            [
                'label'=>'Email',
                'name'=>'email'
            ],
            [
                'label'=>'Dirección',
                'name'=>'address'
            ],
            [
                'label'=>'Teléfono',
                'name'=>'phone'
            ],
        ]);

        $this->crud->addFields([
            [
                'label'=>'Documento',
                'name'=>'document'
            ],
            [
                'label'=>'Nombres',
                'name'=>'first_name'
            ],
            [
                'label'=>'Apellidos',
                'name'=>'last_name'
            ],
            [
                'label'=>'Email',
                'name'=>'email',
                'type'=>'email'
            ],
            [
                'label'=>'Dirección',
                'name'=>'address',
                'type'=>'textarea'
            ],
            [
                'label'=>'Teléfono',
                'name'=>'phone',
                'type'=>'text'
            ],
        ]);

    }

    public function store(tempUserCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(tempUserCrudRequest $request){
        return $this->updateCrud($request);
    }


}

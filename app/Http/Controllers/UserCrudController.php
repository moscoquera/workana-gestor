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
            ],
            [
                'label'=>'Profesión',
                'name'=>'profession',
                'type'=>'select',
                'entity'=>'profession',
                'attribute'=>'name',
                'model'=>'App.Models.Profession'
            ]
        ]);

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
                ],
                [
                    'name'=>'sex',
                    'label'=>'Genero',
                    'type'=>'select_from_array',
                    'options'=>['m'=>'Masculino','f'=>'Femenino'],
                    'allows_null' => false,
                ],
                [
                    'name'=>'date_of_birth',
                    'label'=>'Fecha de nacimiento',
                    'type'=>'date_picker',
                    'date_picker_options' => [
                        'format' => 'dd-mm-yyyy',
                        'language' => 'es',
                        'endDate'=>'0d'
                    ],
                ],
                [
                    'label' => "Nacionalidad",
                    'type' => "select2",
                    'name' => 'nationality_id', // the column that contains the ID of that connected entity
                    'entity' => 'nationality', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\Country", // foreign key model
                ],
                [
                    'label'=>'Dirección de Residencia actual',
                    'type'=>'textarea',
                    'name'=>'current_address',

                ],
                [
                    'label' => "Departamento de Residencia actual",
                    'type' => "select2",
                    'name' => 'current_dep_id', // the column that contains the ID of that connected entity
                    'entity' => 'current_department', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\Department", // foreign key model

                ],
                [
                    // 1-n relationship
                    'label' => "Ciudad de Residencia actual", // Table column heading
                    'type' => "select2_from_ajax_linked",
                    'name' => 'current_city_id', // the column that contains the ID of that connected entity
                    'entity' => 'current_city', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\City", // foreign key model
                    'data_source' => url("api/city"), // url to controller search function (with /{id} should return model)
                    'placeholder' => "Seleccione la ciudad de residencia", // placeholder for the select
                    'minimum_input_length' => 2, // minimum characters to type before querying results
                    'linked_name'=>'current_dep_id',

                ],
                [
                    'label' => "Pais de Residencia actual",
                    'type' => "select2",
                    'name' => 'current_country_id', // the column that contains the ID of that connected entity
                    'entity' => 'current_country', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\Country", // foreign key model

                ],
                [
                    'name'=>'phone',
                    'label'=>'Número de teléfono',
                    'type'=>'text',
                ],
                [
                    'name'=>'mobile',
                    'label'=>'Número celular',
                    'type'=>'text',
                ],
                [
                    'name'=>'profession_id',
                    'label'=>'Profesión',
                    'type'=>'select2',
                    'entity'=>'profession',
                    'attribute'=>'name',
                    'model'=>'App\Models\Profession',
                    'box'=>'general'
                ],




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

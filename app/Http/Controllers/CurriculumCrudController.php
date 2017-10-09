<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurriculumCrudController extends CrudController
{

    public function setup()
    {

        $this->crud->setModel('App\Models\Curriculum');
        $this->crud->setRoute('curriculum');
        $this->crud->setEntityNameStrings('curriculum','curriculums');

        $this->crud->setCreateView('layouts.crud.largeform');

        $this->crud->denyAccess(['list', 'create', 'delete','update']);


        if(Auth::check() && (Auth::user()->isAdmin())){
            $this->crud->denyAccess(['list', 'create', 'delete','update']);
        }else if (Auth::check() && !Auth::user()->curriculum){
            $this->crud->allowAccess('create');
        }

        if (Auth::user()->isAdmin()){
            $this->crud->addField(
                ['name'=>'user_id',
                    'label'=>'Usuario',
                    'type'=>'select2',
                    'entity'=>'user',
                    'attribute'=>'full_name',
                    'model'=>'App\Models\User',
                ]);
        }else{
            $this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=>Auth::user()->id
            ]);
        }

        $this->crud->addFields([
            [
                'name'=>'sex',
                'label'=>'Genero',
                'type'=>'select_from_array',
                'options'=>['m'=>'Masculino','f'=>'Femenino'],
                'allows_null' => false,
            ],
            [
                'name'=>'document',
                'label'=>'Nro de Documento',
                'type'=>'text',
                'hint'=>"Sin puntos, comas o espacios"
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
                'label' => "Departamento de nacimiento",
                'type' => "select2",
                'name' => 'birth_dep_id', // the column that contains the ID of that connected entity
                'entity' => 'birth_department', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Department", // foreign key model
            ],
            [
                // 1-n relationship
                'label' => "Ciudad de nacimiento", // Table column heading
                'type' => "select2_from_ajax_linked",
                'name' => 'birth_city_id', // the column that contains the ID of that connected entity
                'entity' => 'birth_city', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
                'data_source' => url("api/city"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleccione la ciudad de nacimiento", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                'linked_name'=>'birth_dep_id'
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
                'name'=>'current_address'
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
                'linked_name'=>'current_dep_id'
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
                'model'=>'App\Models\Profession'
            ],
            [
                'name'=>'company_id',
                'label'=>'Compañia',
                'type'=>'select2',
                'entity'=>'company',
                'attribute'=>'name',
                'model'=>'App\Models\Company'
            ]

        ]);

        $this->crud->child_resource_included = ['select' => true, 'number' => false];
        $this->crud->child_resource_initialized = ['select' => false, 'number' => false];

        $this->crud->addField([
            'name' => 'educations',
            'label' => 'Estudios',
            'type' => 'child',
            'entity_singular' => 'educación', // used on the "Add X" button
            'columns' => [
                [
                    'label' => 'Tipo',
                    'type' => 'child_select',
                    'name' => 'type_id',
                    'entity' => 'type',
                    'attribute' => 'name',
                    'size' => '3',
                    'model' => "App\Models\Education"
                ],
                [
                    'label' => 'Título',
                    'type' => 'child_text',
                    'name' => 'course_name',
                ],
                [
                    'label' => 'Institución',
                    'type' => 'child_text',
                    'name' => 'institution',
                ],
                [
                    'label' => 'Fecha de finalización',
                    'type' => 'child_date',
                    'name' => 'completion_year',
                ],
            ],
            'max' => 12, // maximum rows allowed in the table
            'min' => 1 // minimum rows allowed in the table
        ]);

        $this->crud->addField([
            'name' => 'experiences',
            'label' => 'Experiencia',
            'type' => 'list',
            'entity_singular' => 'experencia', // used on the "Add X" button
            'view' => 'experience',
            'size'=>11,
            'max' => 12, // maximum rows allowed in the table
            'min' => 1 // minimum rows allowed in the table
        ]);



        $this->crud->addField([
            'name' => 'languages',
            'label' => 'Idiomas',
            'type' => 'child',
            'entity_singular' => 'idioma', // used on the "Add X" button
            'columns' => [
                [
                    'label' => 'Idioma',
                    'type' => 'child_select',
                    'name' => '',
                    'entity' => 'type',
                    'attribute' => 'name',
                    'size' => '3',
                    'model' => "App\Models\Education"
                ],
                [
                    'label' => 'Título',
                    'type' => 'child_text',
                    'name' => 'course_name',
                ],
                [
                    'label' => 'Institución',
                    'type' => 'child_text',
                    'name' => 'institution',
                ],
                [
                    'label' => 'Fecha de finalización',
                    'type' => 'child_date',
                    'name' => 'completion_year',
                ],
            ],
            'max' => 12, // maximum rows allowed in the table
            'min' => 1 // minimum rows allowed in the table
        ]);


    }

}

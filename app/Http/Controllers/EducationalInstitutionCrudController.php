<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationalInstitutionCrudRequest;
use App\Models\City;
use App\Models\Department;
use App\Models\EducationalInstitution;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class EducationalInstitutionCrudController extends CrudController
{


    public function setup()
    {

        $this->crud->setEntityNameStrings('institución','instituciones');
        $this->crud->setRoute('educational-institutions');
        $this->crud->setModel(EducationalInstitution::class);


        $this->crud->addColumns(
            [
                [
                    'label'=>'Id',
                    'name'=>'id'
                ],
                [
                    'label'=>'Nombre',
                    'name'=>'name'
                ],
                [
                    'label'=>'Departamento',
                    'name'=>'department_id',
                    'type'=>'select',
                    'attribute'=>'name',
                    'entity'=>'department',
                    'model'=>Department::class,
                ],
                [
                    'label'=>'Ciudad',
                    'name'=>'city_id',
                    'type'=>'select',
                    'attribute'=>'name',
                    'model'=>City::class,
                    'entity'=>'city'
                ]
            ]
        );



        $this->crud->addFields(
            [
                [
                    'label'=>'Nombre',
                    'name'=>'name'
                ],
                [
                    'label' => "Departamento",
                    'type' => "select2",
                    'name' => 'department_id',
                    'entity' => 'department',
                    'attribute' => "name",
                    'model' => "App\Models\Department",

                ],
                [
                    // 1-n relationship
                    'label' => "Ciudad",
                    'type' => "select2_from_ajax_linked",
                    'name' => 'city_id', // the column that contains the ID of that connected entity
                    'entity' => 'city', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\City", // foreign key model
                    'data_source' => url("api/city"),
                    'placeholder' => "Seleccione la ciudad",
                    'minimum_input_length' => 2,
                    'linked_name'=>'department_id',

                ],
            ]
        );

    }

    public function store(EducationalInstitutionCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(EducationalInstitutionCrudRequest $request){
        return $this->updateCrud($request);
    }

}

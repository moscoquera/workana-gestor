<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CompaniesCrudController extends CrudController
{

    public function setup()
    {
      $this->crud->setModel('App\Models\Company');
      $this->crud->setRoute('companies');
      $this->crud->setEntityNameStrings('empresa','empresas');


      $this->crud->addColumns([
          [
              'name'=>'id',
              'label'=>'id',
              'type'=>'text'
          ],
          [
              'name'=>'name',
              'label'=>'nombre',
              'type'=>'text'
          ],
          [
              'name'=>'nit',
              'label'=>'NIT',
              'type'=>'text'
          ],
          [
              'name'=>'address',
              'label'=>'Dirección',
              'type'=>'text'
          ],
          [
              'name'=>'phone',
              'label'=>'Telefonos',
              'type'=>'text'
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
      ]);


        $this->crud->addFields([
            [
                'name'=>'name',
                'label'=>'nombre',
                'type'=>'text'
            ],
            [
                'name'=>'nit',
                'label'=>'NIT',
                'type'=>'text'
            ],
            [
                'name'=>'address',
                'label'=>'Dirección',
                'type'=>'textarea'
            ],
            [
                'name'=>'phone',
                'label'=>'Telefonos',
                'type'=>'text'
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
        ]);

    }

    public function update(CompanyCrudRequest $request){
        return $this->updateCrud($request);
    }

    public function store(CompanyCrudRequest $request){
        return $this->storeCrud($request);
    }

}

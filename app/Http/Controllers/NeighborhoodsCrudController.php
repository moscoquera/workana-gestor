<?php

namespace App\Http\Controllers;

use App\Http\Requests\NeighborhoodCrudRequest;
use App\Models\Neighborhood;
use App\Models\Town;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Models\City;

class NeighborhoodsCrudController extends CrudController
{


    public function setup()
    {
        $this->crud->setModel(Neighborhood::class);
        $this->crud->setRoute('neighborhoods');
        $this->crud->setEntityNameStrings('barrio','barrios');

        $this->crud->addColumns([
            [
                'label'=>'ID',
                'name'=>'id'
            ],
            [
                'label'=>'Nombre',
                'name'=>'name'
            ],
            [
                'label'=>'Localidad',
                'type'=>'select2',
                'name'=>'town_id',
                'attribute'=>'name',
                'entity'=>'town',

            ],
            [
                'label'=>'Ciudad',
                'type'=>'select',
                'name'=>'city_id',
                'attribute'=>'fullname',
                'entity'=>'city'
            ]
        ]);

        $this->crud->addFields([
            [
                'label'=>'Nombre',
                'name'=>'name',
                'type'=>'text',
            ],
            [
                'label'=>'Ciudad',
                'type'=>'select2',
                'name'=>'city_id',
                'attribute'=>'fullname',
                'entity'=>'city',
                'model'=>City::class,
                'query'=>City::join('departments','cities.department_id','=','departments.id')->selectRaw('cities.*,departments.name as department_name')->orderBy('departments.name'),
            ],
            [

                'label' => "Localidad",
                'type' => "select2_from_ajax_linked",
                'name' => 'town_id',
                'entity' => 'town',
                'attribute' => "name",
                'model' => Town::class,
                'data_source' => url("api/towns"),
                'placeholder' => "NO APLICA",
                'minimum_input_length' => 2,
                'linked_name'=>'city_id',
                'hint'=>'(Opcional)',
                'placeholder_color'=>'#000',

            ],
        ]);

    }


    public function store(NeighborhoodCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(NeighborhoodCrudRequest $request){
        return $this->updateCrud($request);
    }

}

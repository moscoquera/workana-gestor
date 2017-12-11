<?php

namespace App\Http\Controllers;

use App\Http\Requests\TownCrudRequest;
use App\Models\City;
use App\Models\Town;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class TownsCrudController extends CrudController
{

    public function setup()
    {
      $this->crud->setModel(Town::class);
      $this->crud->setRoute('towns');
      $this->crud->setEntityNameStrings('localidad','localidades');

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
          ]
      ]);

    }


    public function store(TownCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function update(TownCrudRequest $request){
        return $this->updateCrud($request);
    }

}

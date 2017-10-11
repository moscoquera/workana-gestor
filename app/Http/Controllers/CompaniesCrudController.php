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
            ]
        ]);

    }

    public function update(CompanyCrudRequest $request){
        return $this->updateCrud($request);
    }

    public function store(CompanyCrudRequest $request){
        return $this->storeCrud($request);
    }

}

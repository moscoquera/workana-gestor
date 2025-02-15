<?php

namespace App\Http\Controllers\Visits;

use App\Models\VisitSubject;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\TypeCrudRequest;

class SubjectCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setEntityNameStrings('asunto','asuntos');
        $this->crud->setRoute('visit-subjects');
        $this->crud->setModel('App\Models\VisitSubject');

        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
            ],
            [
                'name' => 'name',
                'label' => 'Nombre',

            ]
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Nombre',

            ],

        ]);

    }

    public function store(TypeCrudRequest $request)
    {
        return parent::storeCrud($request); // TODO: Change the autogenerated stub
    }

    public function update(TypeCrudRequest $request)
    {
        return parent::updateCrud($request); // TODO: Change the autogenerated stub
    }
}

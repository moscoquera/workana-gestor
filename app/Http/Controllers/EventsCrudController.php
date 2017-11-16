<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\CreateEventCrudRequest;
use App\Http\Requests\Events\UpdateEventCrudRequest;
use App\Models\EventStatus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class EventsCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute('events');
        $this->crud->setEntityNameStrings('evento', 'eventos');


        $this->crud->addColumns([
            [
                'label'=>'Consecutivo',
                'name'=>'id',

            ],
            [
                'name'=>'name',
                'label'=>'Nombre'
            ],
            [
                'label' => "Tipo",
                'type' => "select",
                'name' => 'type_id',
                'entity' => 'type', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\EventType", // foreign key model
            ],
            [
                'name'=>'dateandtime',
                'label'=>'Fecha y hora',
            ],
            [
                'label' => "Municipio",
                'type' => "select",
                'name' => 'city_id',
                'entity' => 'city', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
            ],
            [
                'name'=>'address',
                'label'=>'Lugar del evento'
            ],
            [
                'name'=>'observations',
                'label'=>'Observaciones'
            ],
            [
                'label' => "Responsable del evento",
                'type' => "select",
                'name' => 'user_id',
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => "fullname", // foreign key attribute that is shown to user
                'model' => "App\Models\PublicUser", // foreign key model
            ],
            [
                'label' => "Estado",
                'type' => "select",
                'name' => 'status_id',
                'entity' => 'status', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\EventStatus", // foreign key model
            ],
        ]);


        $this->crud->addFields(
            [
                [
                    'name'=>'name',
                    'label'=>'Nombre',
                    'type'=>'text'
                ],
                [
                    'label' => "Tipo",
                    'type' => "select2",
                    'name' => 'type_id',
                    'entity' => 'type', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\EventType", // foreign key model
                ],
                [
                    'name'=>'dateandtime',
                    'label'=>'Fecha y hora',
                    'type'=>'datetime_picker',
                    'datetime_picker_options' => [
                        'format' => 'DD/MM/YYYY HH:mm',
                        'language' => 'es'
                    ]
                ],
                [
                    'label' => "Municipio",
                    'type' => "select2",
                    'name' => 'city_id',
                    'entity' => 'city', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\City", // foreign key model
                ],
                [
                    'name'=>'address',
                    'label'=>'Lugar del evento',
                    'type'=>'textarea'
                ],
                [
                    'name'=>'observations',
                    'label'=>'Observaciones',
                    'type'=>'textarea'
                ],
                [
                    'label' => "Responsable del evento",
                    'type' => "select2",
                    'name' => 'user_id',
                    'entity' => 'user', // the method that defines the relationship in your Model
                    'attribute' => "fullname", // foreign key attribute that is shown to user
                    'model' => "App\Models\PublicUser", // foreign key model
                ],
            ]
        );

        $this->crud->addField(
            [
                'label' => "Estado",
                'type' => "select2",
                'name' => 'status_id',
                'entity' => 'status', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\EventStatus", // foreign key model
            ],'update');

    }

    public function store(CreateEventCrudRequest $request){
        $activo=EventStatus::where('name','Activo')->first()->id;
        $request->merge([
            'status_id'=>$activo,
        ]);
        return $this->storeCrud($request);
    }

    public function update(UpdateEventCrudRequest $request){
        return $this->updateCrud($request);
    }
}

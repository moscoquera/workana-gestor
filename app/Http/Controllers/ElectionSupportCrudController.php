<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElectionSupportCrudRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class ElectionSupportCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\ElectionUser');
        $this->crud->setRoute('election-supports');
        $this->crud->setEntityNameStrings('apoyo', 'apoyos');
        $this->crud->child_resource_included = ['angular'=>false,'select' => false, 'number' => false, 'date'=>false];
        $this->crud->child_resource_initialized = ['select' => false, 'number' => false];


        $this->crud->addColumns([
            [   'label' => "Fecha Comicio",
                'type' => 'select',
                'name' => 'date_election',
                'entity' => 'election',
                'attribute' => 'date',
                'model' => "App\Models\Election",
                'format'=>'Y-m-d'
            ],
            [
                'label' => "Comicio",
                'type' => 'select',
                'name' => 'election_id', // the db column for the foreign key
                'entity' => 'election', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Election" // foreign key model
            ],
            [
                'label' => "Usuario",
                'type' => 'select',
                'name' => 'user_id', // the db column for the foreign key
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'model' => "App\Models\PublicUser" // foreign key model
            ],
            [
                'label'=>'Votos proyectados',
                'name'=>'proyected_votes'
            ],
            [
                'label'=>'Votos planillados',
                'name'=>'registered_votes'
            ],
            [
                'label'=>'Votos controllados',
                'name'=>'controlled_votes'
            ],
            [
                'label'=>'Votos identificados',
                'name'=>'identified_votes'
            ],
            [
                'label'=>'Transporte solicitado',
                'name'=>'transport_requeriment',
            ],
            [
                'label'=>'Costo del transporte',
                'name'=>'transport_cost'
            ],
            [
                'label'=>'# de refrigerios',
                'name'=>'refreshments'
            ],
            [
                'label'=>'Kit entregado?',
                'name'=>'kit',
                'type'=>'boolean',
                'options' => [0 => 'No', 1 => 'Si']
            ],
            [
                'label'=>'Nomina de apoyo?',
                'name'=>'payroll',
                'type'=>'boolean',
                'options' => [0 => 'No', 1 => 'Si']
            ],
            [
                'label'=>'Valor cuota',
                'name'=>'payment'
            ],
            [
                'label'=>'Número de cuotas',
                'name'=>'number_of_payments'
            ],
            [
                'label'=>'Total aportes entregados',
                'name'=>'total_credits'
            ],
            [
                'label'=>'Total aportes recibidos',
                'name'=>'total_debits'
            ],
            [
                'label'=>'Casa de apoyo?',
                'name'=>'house_support',
                'type'=>'boolean',
                'options' => [0 => 'No', 1 => 'Si']
            ],
            [
                'label' => "Actividad electoral",
                'type' => 'select',
                'name' => 'activity_id', // the db column for the foreign key
                'entity' => 'activity', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\ElectionSupportType" // foreign key model
            ],
        ]);

        $this->crud->addFields([
            [
                'label' => "Comicio",
                'type' => 'select2',
                'name' => 'election_id', // the db column for the foreign key
                'entity' => 'election', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Election" // foreign key model
            ],
            [
                'label' => "Usuario",
                'type' => 'select2',
                'name' => 'user_id', // the db column for the foreign key
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'model' => "App\Models\PublicUser" // foreign key model
            ],
            [
                'label'=>'Votos proyectados',
                'type'=>'number',
                'min'=>0,
                'name'=>'proyected_votes'
            ],
            [
                'label'=>'Votos planillados',
                'type'=>'number',
                'min'=>0,
                'name'=>'registered_votes'
            ],
            [
                'label'=>'Votos controllados',
                'type'=>'number',
                'min'=>0,
                'name'=>'controlled_votes'
            ],
            [
                'label'=>'Votos identificados',
                'type'=>'number',
                'min'=>0,
                'name'=>'identified_votes'
            ],
            [
                'label'=>'Transporte solicitado',
                'type'=>'textarea',
                'name'=>'transport_requeriment',
            ],
            [
                'label'=>'Costo del transporte',
                'type'=>'number',
                'min'=>0,
                'name'=>'transport_cost'
            ],
            [
                'label'=>'# de refrigerios',
                'type'=>'number',
                'min'=>0,
                'name'=>'refreshments'
            ],
            [
                'label'=>'Kit entregado?',
                'name'=>'kit',
                'type'=>'toggle_switch',
                'switch_labels'=>[
                    'on'=>'Si',
                    'off'=>'No'
                ]
            ],
            [
                'label'=>'Nomina de apoyo?',
                'name'=>'payroll',
                'type'=>'toggle_switch',
                'switch_labels'=>[
                    'on'=>'Si',
                    'off'=>'No'
                ]
            ],
            [
                'label'=>'Valor cuota',
                'type'=>'number',
                'min'=>0,
                'name'=>'payment'
            ],
            [
                'label'=>'Número de cuotas',
                'type'=>'number',
                'min'=>0,
                'name'=>'number_of_payments'
            ],
            [
            'label'=>'Casa de apoyo?',
            'name'=>'house_support',
            'type'=>'toggle_switch',
            'switch_labels'=>[
                'on'=>'Si',
                'off'=>'No'
                ]
            ],
            [
                'label' => "Actividad electoral",
                'type' => 'select2',
                'name' => 'activity_id', // the db column for the foreign key
                'entity' => 'activity', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\ElectionSupportType" // foreign key model
            ],

        ]);


        $this->crud->addField([
            'name' => 'credits',
            'label' => 'Aportes entregados',
            'type' => 'child',
            'entity_singular' => 'aporte',
            'columns' => [
                [
                    'label' => 'Fecha',
                    'type' => 'child_date',
                    'name' => 'date',
                    'date_picker_options'=>[
                        'format'=>'yyyy-mm-dd'
                    ]
                ],
                [
                    'label' => 'Valor',
                    'type' => 'child_number',
                    'name' => 'value',

                ],
            ],
            'max' => 10000, // maximum rows allowed in the table
            'min' => 0 // minimum rows allowed in the table
        ]);

        $this->crud->addField([
            'name' => 'debits',
            'label' => 'Aportes recibidos',
            'type' => 'child',
            'entity_singular' => 'aporte',
            'columns' => [
                [
                    'label' => 'Fecha',
                    'type' => 'child_date',
                    'name' => 'date',
                    'date_picker_options'=>[
                        'format'=>'yyyy-mm-dd'
                    ]
                ],
                [
                    'label' => 'Valor',
                    'type' => 'child_number',
                    'name' => 'value',
                ],
            ],
            'max' => 10000, // maximum rows allowed in the table
            'min' => 0 // minimum rows allowed in the table
        ]);


    }



    public function store(ElectionSupportCrudRequest $request)
    {
        return parent::storeCrud($request); // TODO: Change the autogenerated stub
    }

    public function update(ElectionSupportCrudRequest $request)
    {
        return parent::updateCrud($request); // TODO: Change the autogenerated stub
    }

}

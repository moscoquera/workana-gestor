<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElectionCityResultsRequest;
use App\Models\City;
use App\Models\CityElection;
use App\Models\Election;
use App\Models\ElectionCandidate;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class ElectionCityCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setRoute('election-city-results');
        $this->crud->setModel(CityElection::class);
        $this->crud->setEntityNameStrings('registro por municipio y candidatura','registros por municipios y candidaturas');

        $citiesQuery=City::join('departments','departments.id','=','cities.department_id')
            ->select('cities.*')
            ->orderBy('departments.name')
            ->orderBy('cities.name');

        $this->crud->addColumns([
	        [
		        'name'=>'candidacy_id',
		        'label'=>'Candidatura',
		        'type'=>'select',
		        'entity'=>'candidacy',
		        'attribute'=>'full_name'
	        ],
	        [  // Select2
                'label' => "Municipio",
                'type' => 'select',
                'name' => 'city_id', // the db column for the foreign key
                'entity' => 'city', // the method that defines the relationship in your Model
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'model' => City::class,
            ],
            [
                'label'=>'Total planillados',
                'type'=>'number',
                'name'=>'inscribed'
            ],
	        [
		        'label'=>'Total registrados',
		        'type'=>'number',
		        'name'=>'registered'
	        ],
	        [
		        'label'=>'Total votos finales',
		        'type'=>'number',
		        'name'=>'votes'
	        ],
	        [
		        'label'=>'Efectividad',
		        'name'=>'effectivity'
	        ]
        ]);


        $this->crud->addFields([
	        [
		        'name'=>'candidacy_id',
		        'label'=>'Candidatura',
		        'type'=>'select2',
		        'entity'=>'candidacy',
		        'attribute'=>'full_name',
		        'attributes'=>['required'=>'required']
	        ],
	        [  // Select2
                'label' => "Municipio",
                'type' => 'select2',
                'name' => 'city_id', // the db column for the foreign key
                'entity' => 'city', // the method that defines the relationship in your Model
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'model' => City::class,
                'query'=>$citiesQuery,
            ],
	        [
		        'label'=>'Total planillados',
		        'name'=>'inscribed',
		        'type'=>'number',
		        'attributes'=>['min'=>0]
	        ],
	        [
		        'label'=>'Total registrados',
		        'name'=>'registered',
		        'type'=>'number',
		        'attributes'=>['min'=>0]
	        ],
	        [
		        'label'=>'Total votos finales',
		        'name'=>'votes',
		        'type'=>'number',
		        'attributes'=>['min'=>0,'required'=>'required']
	        ],
	        [
		        'label'=>'Efectividad',
		        'name'=>'effectivity',
		        'type'=>'textarea',
	        ],

        ]);
    }

    function Store(ElectionCityResultsRequest $request){
        return $this->storeCrud($request);
    }

    public function Update(ElectionCityResultsRequest $request){
        return $this->updateCrud($request);
    }


}

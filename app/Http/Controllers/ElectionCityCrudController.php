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
        $this->crud->setEntityNameStrings('resultado','resultados');

        $citiesQuery=City::join('departments','departments.id','=','cities.department_id')
            ->select('cities.*')
            ->orderBy('departments.name')
            ->orderBy('cities.name');

        $this->crud->addColumns([
            [  // Select2
                'label' => "Comicio",
                'type' => 'select',
                'name' => 'election_id', // the db column for the foreign key
                'entity' => 'candidature', // the method that defines the relationship in your Model
                'attribute' => 'election.name', // foreign key attribute that is shown to user
                'model' => ElectionCandidate::class,
            ],
            [
                'label' => "Candidato", // Table column heading
                'type' => "select",
                'name' => 'election_candidate_id', // the column that contains the ID of that connected entity
                'entity' => 'candidature', // the method that defines the relationship in your Model
                'attribute' => "candidate.name", // foreign key attribute that is shown to user
                'model' => ElectionCandidate::class,
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
                'label'=>'Total votos',
                'type'=>'number',
                'name'=>'votes'
            ]
        ]);


        $this->crud->addFields([
            [  // Select2
                'label' => "Comicio",
                'type' => 'fake_select2',
                'name' => 'election_id', // the db column for the foreign key
                'entity' => 'election', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => Election::class,
            ],
            [
                'label' => "Candidato", // Table column heading
                'type' => "select2_from_ajax_linked",
                'name' => 'election_candidate_id', // the column that contains the ID of that connected entity
                'entity' => 'candidate', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => ElectionCandidate::class,
                'data_source' => url("ajax/election/candidate"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleccione un candidato", // placeholder for the select
                'minimum_input_length' => 1, // minimum characters to type before querying results
                'linked_name'=>'election_id',
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
                'label'=>'Total votos',
                'type'=>'number',
                'name'=>'votes'
            ]
        ]);
    }

    function Store(ElectionCityResultsRequest $request){
        return $this->storeCrud($request);
    }

    public function Update(ElectionCityResultsRequest $request){
        return $this->updateCrud($request);
    }


}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaciesLocationRequest;
use App\Models\CandidaciesRegistryLocation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidaciesRegistryLocationController extends CrudController
{

	public function setup()
	{
		$this->crud->setRoute('election-location-results');
		$this->crud->setModel(CandidaciesRegistryLocation::class);
		$this->crud->setEntityNameStrings('registro por puesto de votación','registros por puestos de votación');

		$this->crud->addColumns([
			[
				'name'=>'candidacy_id',
				'label'=>'Candidatura',
				'type'=>'select',
				'entity'=>'candidacy',
				'attribute'=>'full_name'
			],
			[
				'label'=>'Puesto de votación',
				'name'=>'poll_place'
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
			[
				'label'=>'Puesto de votación',
				'name'=>'poll_place',
				'attributes'=>['required'=>'required']
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

	function Store(CandidaciesLocationRequest $request){
		return $this->storeCrud($request);
	}

	public function Update(CandidaciesLocationRequest $request){
		return $this->updateCrud($request);
	}


}

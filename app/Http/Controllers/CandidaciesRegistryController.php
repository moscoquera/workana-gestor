<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaciesRegistryRequest;
use App\Models\CandidaciesRegistry;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidaciesRegistryController extends CrudController
{


	public function setup() {
		$this->crud->setModel(CandidaciesRegistry::class);
		$this->crud->setEntityNameStrings('registro','registgros');
		$this->crud->setRoute('candidacies-registry');


		$this->crud->addColumns([
			[
				'name'=>'candidacy_id',
				'label'=>'Candidatura',
				'type'=>'select',
				'entity'=>'candidacy',
				'attribute'=>'full_name'
			],
			[
				'name'=>'registered',
				'label'=>'Planillados registrados',
			],
			[
				'name'=>'controlled',
				'label'=>'Planillados controlados',
			],
			[
				'name'=>'manual',
				'label'=>'Planillados manuales',
			],
			[
				'name'=>'precounted',
				'label'=>'Votos preconteo',
			],
			[
				'name'=>'final',
				'label'=>'Votos finales',
			],
			[
				'name'=>'visited',
				'label'=>'Total de planillados visitados',
			],
			[
				'name'=>'trained',
				'label'=>'Total de planillados entrenados',
			],

		]);

		$this->crud->addFields([
			[
				'name'=>'candidacy_id',
				'label'=>'Candidatura',
				'type'=>'select2',
				'entity'=>'candidacy',
				'attribute'=>'full_name'
			],
			[
				'name'=>'registered',
				'label'=>'Planillados registrados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'controlled',
				'label'=>'Planillados controlados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'manual',
				'label'=>'Planillados manuales',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'precounted',
				'label'=>'Votos preconteo',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'final',
				'label'=>'Votos finales',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'effectivity',
				'label'=>'Efectividad',
				'type'=>'textarea'
			],
			[
				'name'=>'visited',
				'label'=>'Total de planillados visitados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],

			[
				'name'=>'trained',
				'label'=>'Total de planillados entrenados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],


		]);

	}

	public function store(CandidaciesRegistryRequest $request){
		return $this->storeCrud($request);
	}


	public function update(CandidaciesRegistryRequest $request){
		return $this->updateCrud($request);
	}
}

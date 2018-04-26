<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaciesBonificationsRequest;
use App\Models\CandidaciesBonifications;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidaciesBonificationsController extends CrudController
{


	public function setup() {
		$this->crud->setModel(CandidaciesBonifications::class);
		$this->crud->setEntityNameStrings('registro bonificaciones','registros de bonificaciones');
		$this->crud->setRoute('candidacies-bonifications');


		$this->crud->addColumns([
			[
				'name'=>'candidacy_id',
				'label'=>'Candidatura',
				'type'=>'select',
				'entity'=>'candidacy',
				'attribute'=>'full_name'
			],
			[
				'name'=>'bonuses',
				'label'=>'Total  de bonificados',
			],
			[
				'name'=>'bonified',
				'label'=>'Total de bonos',
			],
			[
				'name'=>'rosted',
				'label'=>'Total de nomina',
			],
			[
				'name'=>'workers',
				'label'=>'Total de trabajadores',
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
				'name'=>'bonuses',
				'label'=>'Total  de bonificados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'bonified',
				'label'=>'Total de bonos',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'rosted',
				'label'=>'Total de nomina',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'workers',
				'label'=>'Total de trabajadores',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],


		]);

	}

	public function store(CandidaciesBonificationsRequest $request){
		return $this->storeCrud($request);
	}


	public function update(CandidaciesBonificationsRequest $request){
		return $this->updateCrud($request);
	}
}

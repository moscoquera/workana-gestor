<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaciesTransportRequest;
use App\Models\CandidaciesTransport;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidaciesTransportController extends CrudController
{

	public function setup() {
		$this->crud->setModel(CandidaciesTransport::class);
		$this->crud->setEntityNameStrings('registro transportes','registros de transportes');
		$this->crud->setRoute('candidacies-transport');


		$this->crud->addColumns([
			[
				'name'=>'candidacy_id',
				'label'=>'Candidatura',
				'type'=>'select',
				'entity'=>'candidacy',
				'attribute'=>'full_name'
			],
			[
				'name'=>'requested',
				'label'=>'Transporte solicitado',
			],
			[
				'name'=>'given',
				'label'=>'Transporte entregado',
			],
			[
				'name'=>'cost',
				'label'=>'Costos del transporte',
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
				'name'=>'requested',
				'label'=>'Transporte solicitado',
				'type'=>'textarea',
			],
			[
				'name'=>'given',
				'label'=>'Transporte entregado',
				'type'=>'textarea',
			],
			[
				'name'=>'cost',
				'label'=>'Costos del transporte',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],


		]);

	}

	public function store(CandidaciesTransportRequest $request){
		return $this->storeCrud($request);
	}


	public function update(CandidaciesTransportRequest $request){
		return $this->updateCrud($request);
	}

}

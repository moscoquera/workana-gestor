<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaciesZonedRequest;
use App\Models\CandidaciesZoned;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidaciesZonedController extends CrudController
{


	public function setup() {
		$this->crud->setModel(CandidaciesZoned::class);
		$this->crud->setEntityNameStrings('registro zonificado','registgros zonificados');
		$this->crud->setRoute('candidacies-zoned');

		$this->crud->addColumns([
			[
				'name'=>'id',
				'label'=>'#ID'
			],
			[
				'name'=>'candidacy_id',
				'label'=>'Candidatura',
				'type'=>'select',
				'entity'=>'candidacy',
				'attribute'=>'full_name'
			],
			[
				'name'=>'total',
				'label'=>'Total zonificados',
			],
			[
				'name'=>'without_incidence',
				'label'=>'Sin incidencia',
			],
			[
				'name'=>'with_incidence',
				'label'=>'Con incidencias',
			],
			[
				'name'=>'proyected',
				'label'=>'Total Proyectados',
			],
			[
				'name'=>'percentage',
				'label'=>'Porcentaje de cumplimiento (%)',
			]
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
				'name'=>'total',
				'label'=>'Total zonificados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'without_incidence',
				'label'=>'Sin incidencia',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'with_incidence',
				'label'=>'Con incidencias',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'proyected',
				'label'=>'Total Proyectados',
				'type'=>'number',
				'attributes'=>['min'=>0,'required'=>'required']
			],
			[
				'name'=>'percentage',
				'label'=>'Porcentaje de cumplimiento',
				'type'=>'number',
				'attributes' => ["step" => "any",'min'=>0,'max'=>100,'required'=>'required'],
				'suffix'=>' %'
			]
		]);
	}

	public function store(CandidaciesZonedRequest $request){
		return $this->storeCrud($request);
	}


	public function update(CandidaciesZonedRequest $request){
		return $this->updateCrud($request);
	}

}

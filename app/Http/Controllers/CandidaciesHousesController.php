<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidaciesHousesRequest;
use App\Models\CandidaciesHouses;
use App\Models\SupportHouse;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidaciesHousesController extends CrudController
{


	public function setup() {
		$this->crud->setModel(CandidaciesHouses::class);
		$this->crud->setEntityNameStrings('registro casa de apoyo','registgros por casas de apoyo');
		$this->crud->setRoute('candidacies-houses');


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
				'name'=>'support_house_id',
				'label'=>'Puesto de votación',
				'type'=>'select',
				'entity'=>'support_house',
				'attribute'=>'poll_place',
				'model'=>SupportHouse::class
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
				'name'=>'support_house_id',
				'label'=>'Puesto de votación',
				'type'=>'select2',
				'entity'=>'support_house',
				'attribute'=>'poll_place',
				'model'=>SupportHouse::class
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

		]);

	}

	public function store(CandidaciesHousesRequest $request){
		return $this->storeCrud($request);
	}

	public function update(CandidaciesHousesRequest $request){
		return $this->updateCrud($request);
	}

}

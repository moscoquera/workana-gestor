<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportHouseRequest;
use App\Models\City;
use App\Models\SupportHouse;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class SupportHouseController extends CrudController
{

	public function setup() {
		$this->crud->setModel(\App\Models\SupportHouse::class);
		$this->crud->setEntityNameStrings('casa de apoyo','casas de apoyo');
		$this->crud->setRoute('houses');

		$this->crud->addColumns([
			[
				'name'=>'poll_place',
				'label'=>'Lugar de votación',
			],
			[
				'name'=>'city_id',
				'label'=>'Municipio',
				'type'=>'select',
				'entity'=>'city',
				'attribute'=>'name',
				'model'=>City::class

			],
			[
				'name'=>'address',
				'label'=>'Dirección',
			],
			[
				'name'=>'phone',
				'label'=>'Teléfono',
			],
			[
				'name'=>'contact',
				'label'=>'Contacto'
			],
			[
				'name'=>'enter_date',
				'label'=>'Fecha de registro',
				'type'=>'date_picker',
				'date_picker_options'=>[
					'todayBtn'=>true,
					'format'=>'yyyy-mm-dd',
					'language'=>'es'
				]

			]
		]);

		$this->crud->addFields([
			[
				'name'=>'poll_place',
				'label'=>'Lugar de votación',
			],
			[
				'name'=>'city_id',
				'label'=>'Municipio',
				'type'=>'select2',
				'entity'=>'city',
				'attribute'=>'name',
				'model'=>City::class

			],
			[
				'name'=>'address',
				'label'=>'Dirección',
			],
			[
				'name'=>'phone',
				'label'=>'Teléfono',
			],
			[
				'name'=>'contact',
				'label'=>'Contacto'
			],
			[
				'name'=>'enter_date',
				'label'=>'Fecha de registro',
				'type'=>'date_picker',
				'date_picker_options'=>[
					'todayBtn'=>true,
					'format'=>'yyyy-mm-dd',
					'language'=>'es'
				]

			]

		]);
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupportHouseRequest $request)
    {
        return $this->storeCrud($request);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupportHouse  $supportHouse
     * @return \Illuminate\Http\Response
     */
    public function update(SupportHouseRequest $request, SupportHouse $supportHouse)
    {
        return $this->updateCrud($request);
    }

}

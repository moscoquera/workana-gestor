<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateCrudRequest;
use App\Models\Department;
use App\Models\Profession;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class CandidatesCrudController extends CrudController
{


    public function setup()
    {
        $this->crud->setModel('App\Models\Candidate');
        $this->crud->setRoute('candidates');
        $this->crud->setEntityNameStrings('candidato', 'candidatos');

        $this->crud->addColumns([
        	[
                'name' => 'id',
                'label' => 'ID',
            ],
	        [
		        'name'=>'photo',
		        'label'=>'Foto',
		        'type'=>'image',
		        'prefix'=>'storage/',
		        'height'=>'60px',
		        'width'=>'60px'
	        ],
            [
                'name' => 'first_name',
                'label' => 'Nombres',

            ],
	        [
	        	'name'=>'last_name',
		        'label'=>'Apellidos',
	        ],
	        [
	        	'name'=>'document',
		        'label'=>'Cédula'
	        ],
	        [
	        	'name'=>'profession_id',
		        'label'=>'Profesión',
		        'type'=>'select',
		        'entity'=>'profession',
		        'attribute'=>'name'
	        ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'first_name',
                'label' => 'Nombres',

            ],
	        [
				'name'=>'last_name',
		        'label'=>'Apellidos'
	        ],
	        [
	        	'name'=>'document',
		        'label'=>'Cédula'
	        ],
	        [
		        'label' => "Departamento",
		        'type' => "select2",
		        'name' => 'department_id',
		        'entity' => 'department',
		        'attribute' => "name",
		        'model' => Department::class ,
	        ],
	        [

		        'label' => "Municipio",
		        'type' => "select2_from_ajax_linked",
		        'name' => 'city_id',
		        'entity' => 'city',
		        'attribute' => "name", // foreign key attribute that is shown to user
		        'model' => "App\Models\City", // foreign key model
		        'data_source' => url("api/city"), // url to controller search function (with /{id} should return model)
		        'placeholder' => "Seleccione el municipio", // placeholder for the select
		        'minimum_input_length' => 2, // minimum characters to type before querying results
		        'linked_name'=>'department_id',
	        ],
	        [
		        'label' => "Profesión",
		        'type' => "select2",
		        'name' => 'profession_id',
		        'entity' => 'profession',
		        'attribute' => "name",
		        'model' => Profession::class,
	        ],
	        [
	        	'name'=>'address',
		        'label'=>'Dirección'
	        ],
	        [
	        	'name'=>'phone',
		        'label'=>'Teléfono'
	        ],
	        [
		        'name'=>'phone_alt',
		        'label'=>'Teléfono alternativo'
	        ],
	        [ // image
		        'label' => "Fotografía",
		        'box'=>'general',
		        'name' => "photo",
		        'type' => 'image',
		        'upload' => true,
		        'crop'=>true,
		        'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
		        'prefix' => '/storage/', // in case you only store the filename in the database, this text will be prepended to the database value
		        'default'=>'images/no-photo.png'
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



    public function store(CandidateCrudRequest $request)
    {
        return parent::storeCrud($request); // TODO: Change the autogenerated stub
    }

    public function update(CandidateCrudRequest $request)
    {
        return parent::updateCrud($request); // TODO: Change the autogenerated stub
    }


}

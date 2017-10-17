<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curriculum\CreateCurriculumRequest;
use App\Models\Curriculum;
use App\Models\CurriculumEducation;
use App\Models\PublicUser;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\Exception\AccessDeniedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\SaveActions;
use Illuminate\Routing\Route;
use niklasravnsborg\LaravelPdf\Facades\Pdf as PDF;

class CurriculumCrudController extends CrudController
{

    use SaveActions{
        getSaveActionButtonName as protected getSaveActionButtonNameTrait;
    }


    public function setup()
    {

        $this->crud->setModel('App\Models\Curriculum');
        $this->crud->setRoute('curriculum');
        $this->crud->setEntityNameStrings('curriculum','curriculums');

        $this->crud->setCreateView('layouts.crud.largeform');

        $this->crud->denyAccess(['list', 'create', 'delete','update']);

        if(Auth::check() && (Auth::user()->isAdmin())){
            $this->crud->denyAccess(['list', 'create', 'delete','update']);
        }else if (Auth::check() && !Auth::user()->curriculum){
            $this->crud->allowAccess('create');
        }else if (Auth::check() && Auth::user()->curriculum){
            $this->crud->allowAccess(['update','show']);
            $this->crud->setShowView('curriculum.show');
        }

        if (Auth::user()->isAdmin()){
            $this->crud->addField(
                ['name'=>'user_id',
                    'label'=>'Usuario',
                    'type'=>'select2',
                    'entity'=>'user',
                    'attribute'=>'full_name',
                    'model'=>'App\Models\User',
                ]);
        }else{
            $this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=>Auth::user()->id
            ]);
        }

        $this->crud->addFields([
            [
                'name'=>'sex',
                'label'=>'Genero',
                'type'=>'select_from_array',
                'options'=>['m'=>'Masculino','f'=>'Femenino'],
                'allows_null' => false,
            ],
            [
                'name'=>'document',
                'label'=>'Nro de Documento',
                'type'=>'text',
                'hint'=>"Sin puntos, comas o espacios"
            ],
            [
                'name'=>'date_of_birth',
                'label'=>'Fecha de nacimiento',
                'type'=>'date_picker',
                'date_picker_options' => [
                    'format' => 'dd-mm-yyyy',
                    'language' => 'es',
                    'endDate'=>'0d'
                ],
            ],
            [
                'label' => "Departamento de nacimiento",
                'type' => "select2",
                'name' => 'birth_dep_id', // the column that contains the ID of that connected entity
                'entity' => 'birth_department', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Department", // foreign key model
            ],
            [
                // 1-n relationship
                'label' => "Ciudad de nacimiento", // Table column heading
                'type' => "select2_from_ajax_linked",
                'name' => 'birth_city_id', // the column that contains the ID of that connected entity
                'entity' => 'birth_city', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
                'data_source' => url("api/city"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleccione la ciudad de nacimiento", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                'linked_name'=>'birth_dep_id'
            ],
            [
                'label' => "Nacionalidad",
                'type' => "select2",
                'name' => 'nationality_id', // the column that contains the ID of that connected entity
                'entity' => 'nationality', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Country", // foreign key model
            ],
            [
                'label'=>'Dirección de Residencia actual',
                'type'=>'textarea',
                'name'=>'current_address'
            ],
            [
                'label' => "Departamento de Residencia actual",
                'type' => "select2",
                'name' => 'current_dep_id', // the column that contains the ID of that connected entity
                'entity' => 'current_department', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Department", // foreign key model
            ],
            [
                // 1-n relationship
                'label' => "Ciudad de Residencia actual", // Table column heading
                'type' => "select2_from_ajax_linked",
                'name' => 'current_city_id', // the column that contains the ID of that connected entity
                'entity' => 'current_city', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
                'data_source' => url("api/city"), // url to controller search function (with /{id} should return model)
                'placeholder' => "Seleccione la ciudad de residencia", // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                'linked_name'=>'current_dep_id'
            ],
            [
                'label' => "Pais de Residencia actual",
                'type' => "select2",
                'name' => 'current_country_id', // the column that contains the ID of that connected entity
                'entity' => 'current_country', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Country", // foreign key model
            ],
            [
                'name'=>'phone',
                'label'=>'Número de teléfono',
                'type'=>'text',
            ],
            [
                'name'=>'mobile',
                'label'=>'Número celular',
                'type'=>'text',
            ],
            [
                'name'=>'profession_id',
                'label'=>'Profesión',
                'type'=>'select2',
                'entity'=>'profession',
                'attribute'=>'name',
                'model'=>'App\Models\Profession'
            ],
            [
                'name'=>'company_id',
                'label'=>'Empresa',
                'type'=>'select2',
                'entity'=>'company',
                'attribute'=>'name',
                'model'=>'App\Models\Company'
            ],
            [       // Select2Multiple = n-n relationship (with pivot table)
                'label' => "Habilidades",
                'type' => 'select2_multiple',
                'name' => 'skills', // the method that defines the relationship in your Model
                'entity' => 'skills', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Skill", // foreign key model
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            ],
            [
                'label'=>'Resumen',
                'type'=>'textarea',
                'name'=>'resume',
                'hint'=>'Cuentenos sobre usted',
            ],
            [ // image
                'label' => "Fotografía",
                'name' => "photo",
                'type' => 'image',
                'upload' => true,
                'crop'=>true,
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                'prefix' => '/storage/' // in case you only store the filename in the database, this text will be prepended to the database value
            ]
        ]);



        $this->crud->child_resource_included = ['angular'=>false,'select' => true, 'number' => false];
        $this->crud->child_resource_initialized = ['select' => false, 'number' => false];

        $this->crud->addField([
            'name' => 'educations',
            'label' => 'Estudios',
            'type' => 'child',
            'entity_singular' => 'educación', // used on the "Add X" button
            'columns' => [
                [
                    'label' => 'Tipo',
                    'type' => 'child_select',
                    'name' => 'type_id',
                    'entity' => 'type',
                    'attribute' => 'name',
                    'size' => '3',
                    'model' => "App\Models\Education"
                ],
                [
                    'label' => 'Título',
                    'type' => 'child_text',
                    'name' => 'course_name',
                ],
                [
                    'label' => 'Institución',
                    'type' => 'child_text',
                    'name' => 'institution',
                ],
                [
                    'label' => 'Fecha de finalización',
                    'type' => 'child_date',
                    'name' => 'completion_year',
                    'date_picker_options'=>[
                        'format'=>'dd-mm-yyyy'
                    ]
                ],
            ],
            'max' => 12, // maximum rows allowed in the table
            'min' => 1 // minimum rows allowed in the table
        ]);

        $this->crud->addField([
            'name' => 'experiences',
            'label' => 'Experiencia',
            'type' => 'list',
            'entity_singular' => 'experencia', // used on the "Add X" button
            'view' => 'experience',
            'size'=>11,
            'max' => 12, // maximum rows allowed in the table
            'min' => 0 // minimum rows allowed in the table
        ]);

        $this->crud->addField([
            'name' => 'languages',
            'label' => 'Idiomas',
            'type' => 'child',
            'child_pivot'=>'proficency',
            'entity_singular' => 'idioma', // used on the "Add X" button
            'columns' => [
                [
                    'label' => 'Idioma',
                    'type' => 'child_select',
                    'name' => 'language_id',
                    'entity' => 'type',
                    'attribute' => 'name',
                    'size' => '3',
                    'model' => "App\Models\Language"
                ],
                [
                    'label' => 'Nivel escrito',
                    'type' => 'child_select_array',
                    'name' => 'writing',
                    'options'=>[
                        [
                            'id'=>'0',
                            'label'=>'Bajo'
                        ],
                        [
                            'id'=>'1',
                            'label'=>'Medio'
                        ],
                        [
                            'id'=>'2',
                            'label'=>'Alto'
                        ],
                        [
                            'id'=>'3',
                            'label'=>'Nativo'
                        ]
                    ]
                ],
                [
                    'label' => 'Nivel hablado',
                    'type' => 'child_select_array',
                    'name' => 'speaking',
                    'options'=>[
                        [
                            'id'=>'0',
                            'label'=>'Bajo'
                        ],
                        [
                            'id'=>'1',
                            'label'=>'Medio'
                        ],
                        [
                            'id'=>'2',
                            'label'=>'Alto'
                        ],
                        [
                            'id'=>'3',
                            'label'=>'Nativo'
                        ]
                    ]
                ]

            ],
            'max' => 12, // maximum rows allowed in the table
            'min' => 1 // minimum rows allowed in the table
        ]);

        $this->crud->addField([
            'name' => 'familiar_references',
            'label' => 'Referencias familiares',
            'type' => 'child',
            'entity_singular' => 'referencia', // used on the "Add X" button
            'columns' => [
                [
                    'label' => 'Nombre completo',
                    'type' => 'child_text',
                    'name' => 'fullname',
                ],
                [
                    'label' => 'Profesión',
                    'type' => 'child_text',
                    'name' => 'profession',
                ],
                [
                    'label' => 'Teléfono',
                    'type' => 'child_text',
                    'name' => 'phone',
                ],

            ],
            'max' => 3, // maximum rows allowed in the table
            'min' => 3 // minimum rows allowed in the table
        ]);


        $this->crud->addField([
            'name' => 'personal_references',
            'label' => 'Referencias personales',
            'type' => 'child',
            'entity_singular' => 'referencia', // used on the "Add X" button
            'columns' => [
                [
                    'label' => 'Nombre completo',
                    'type' => 'child_text',
                    'name' => 'fullname',
                ],
                [
                    'label' => 'Profesión',
                    'type' => 'child_text',
                    'name' => 'profession',
                ],
                [
                    'label' => 'Teléfono',
                    'type' => 'child_text',
                    'name' => 'phone',
                ],

            ],
            'max' => 3, // maximum rows allowed in the table
            'min' => 3 // minimum rows allowed in the table
        ]);

    }


    public function store(CreateCurriculumRequest $request){

        if($request->user()->curriculum){
            return redirect('/');
        }
        return $this->storeCrud($request);

    }

    public function update(CreateCurriculumRequest $request)
    {

        if ($request->input('user_id')!=Auth::user()->id){
            return redirect('/');
        }

        return $this->updateCrud($request); // TODO: Change the autogenerated stub

    }





    public function performSaveAction($itemId = null)
    {
        if (Auth::user()->isAdmin()){return parent::performSaveAction($itemId);}

        $saveAction = \Request::input('save_action', config('backpack.crud.default_save_action', 'save_and_back'));
        $itemId = $itemId ? $itemId : \Request::input('id');
        switch ($saveAction) {
            case 'save_and_new':
                $redirectUrl = $this->crud->route.'/create';
                break;
            case 'save_and_edit':
                $redirectUrl = $this->crud->route.'/'.$itemId.'/edit';
                if (\Request::has('locale')) {
                    $redirectUrl .= '?locale='.\Request::input('locale');
                }
                break;
            case 'save_and_back':
            default:
                $redirectUrl = URL::previous();
                break;
        }
        return \Redirect::to($redirectUrl);
    }

    public function getSaveAction(){
        if (Auth::user()->isAdmin()){return parent::getSaveAction();}
        $saveOptions = [];
        $saveCurrent = [
            'value' => 'save_and_edit',
            'label' => $this->getSaveActionButtonNameTrait('save_and_edit'),
        ];
        return [
            'active' => $saveCurrent,
            'options' => $saveOptions,
        ];
    }

    public function create()
    {
        try{
            return parent::create(); // TODO: Change the autogenerated stub
        }catch (AccessDeniedException $ex){
            return redirect('/');
        }
    }

    public function edit($id)
    {
        try {
            return parent::edit($id); // TODO: Change the autogenerated stub
        }catch(AccessDeniedException $ex){
            return redirect('/');
        }
    }

    public function show($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            if (!Auth::user()->isAdmin() && $curriculum->user->id != Auth::user()->id) {
                return redirect('/');
            }
            return view('curriculum.show', ['curriculum' => $curriculum]);
        } catch (ModelNotFoundException $mnfe) {
            return parent::show($id);
        }
    }

        public function export($id)
        {
            try {
                $curriculum = Curriculum::findOrFail($id);
                if (!Auth::user()->isAdmin() && $curriculum->user->id != Auth::user()->id) {
                    return redirect('/');
                }

                $pdf = PDF::loadView('curriculum.pdf', ['curriculum' => $curriculum,'show'=>true]);
                return $pdf->stream('curriculum_'.$id.'.pdf');
             //   return view('curriculum.pdf', ['curriculum' => $curriculum,'show'=>true]);
            } catch (ModelNotFoundException $mnfe) {
                return parent::show($id);
            }
        }


}

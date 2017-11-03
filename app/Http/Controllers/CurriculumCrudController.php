<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curriculum\CreateCurriculumRequest;
use App\Models\Curriculum;
use App\Models\CurriculumEducation;
use App\Models\PublicUser;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\Exception\AccessDeniedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\SaveActions;
use Illuminate\Routing\Route;
use niklasravnsborg\LaravelPdf\Facades\Pdf as PDF;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\DropzoneRequest;


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

        $this->crud->setCreateView('curriculum.create');
        $this->crud->setEditView('curriculum.edit');
        $this->crud->denyAccess(['list', 'create', 'delete','update']);

        if(Auth::check() && (Auth::user()->isAdmin())){
            $this->crud->allowAccess(['create','update']);
            $this->crud->denyAccess(['list', 'delete']);
        }else if (Auth::check() && !Auth::user()->curriculum){
            $this->crud->allowAccess('create');
        }else if (Auth::check() && Auth::user()->curriculum){
            $this->crud->allowAccess(['update','show']);
            $this->crud->setShowView('curriculum.show');
        }

        $this->crud->layouts=[
            [
                [
                    'size'=>6,
                    'boxes'=>[
                        [
                            'title'=>'General',
                            'name'=>'general'
                        ]
                    ]
                ],
                [
                    'size'=>'6',
                    'boxes'=>[
                        [
                            'title'=>'Datos personales',
                            'name'=>'personal'
                        ]
                    ]
                ]
            ],
            [
                [
                    'size'=>4,
                    'boxes'=>[
                        [
                            'title'=>'Dirección y contacto',
                            'name'=>'address'
                        ],

                    ]
                ],
                [
                    'size'=>8,
                    'boxes'=>[
                        [
                            'title'=>'Otros',
                            'name'=>'others'
                        ]
                    ]
                ]
            ],
            [
                [
                    'size'=>4,
                    'boxes'=>[
                        [
                            'title'=>'Formación academica',
                            'name'=>'educations'
                        ],
                        [
                            'title'=>'Idiomas',
                            'name'=>'languages'
                        ]
                    ]
                ],
                [
                    'size'=>8,
                    'boxes'=>[
                        [
                            'title'=>'Experiencia laboral',
                            'name'=>'experience'
                        ],
                        [
                            'title'=>'Referencias familiares',
                            'name'=>'familiarref'
                        ],
                        [
                            'title'=>'Referencias personales',
                            'name'=>'personalref'
                        ]
                    ]
                ]
            ],
            [
                [
                    'size'=>12,
                    'boxes'=>[
                        [
                            'title'=>'Evidencias',
                            'name'=>'attachments'
                        ]
                    ]
                ]

            ]
        ];

        if (Auth::user()->isAdmin()){



                $puser = User::find($this->request->input('user'));
                if($puser){

                    $this->crud->addField(
                        ['name'=>'user_id',
                            'type'=>'hidden',
                            'value'=> $puser->id,
                            'box'=>'personal'
                        ]);
                }elseif($this->request->route('curriculum')){
                    $pcurr = Curriculum::find($this->request->route('curriculum'));
                    $this->crud->addField(
                        ['name'=>'user_id',
                            'type'=>'hidden',
                            'value'=> $pcurr->user->id,
                            'box'=>'personal'
                        ]);
                }
        }elseif (!Auth::user()->isAdmin()){
            $this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=>Auth::user()->id,
                    'box'=>'personal'
            ]);
        }

        $this->crud->addFields([
            [ // image
                'label' => "Fotografía",
                'box'=>'general',
                'name' => "photo",
                'type' => 'image',
                'upload' => true,
                'crop'=>true,
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                'prefix' => '/storage/' // in case you only store the filename in the database, this text will be prepended to the database value
            ],
            [
                'name'=>'sex',
                'label'=>'Genero',
                'type'=>'select_from_array',
                'options'=>['m'=>'Masculino','f'=>'Femenino'],
                'allows_null' => false,
                'box'=>'personal'
            ],
            [
                'name'=>'document',
                'label'=>'Nro de Documento',
                'type'=>'text',
                'hint'=>"Sin puntos, comas o espacios",
                'box'=>'personal'
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
                'box'=>'personal'
            ],
            [
                'label' => "Departamento de nacimiento",
                'type' => "select2",
                'name' => 'birth_dep_id', // the column that contains the ID of that connected entity
                'entity' => 'birth_department', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Department", // foreign key model
                'box'=>'personal'
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
                'linked_name'=>'birth_dep_id',
                'box'=>'personal'
            ],
            [
                'label' => "Nacionalidad",
                'type' => "select2",
                'name' => 'nationality_id', // the column that contains the ID of that connected entity
                'entity' => 'nationality', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Country", // foreign key model
                'box'=>'personal'
            ],
            [
                'label'=>'Dirección de Residencia actual',
                'type'=>'textarea',
                'name'=>'current_address',
                'box'=>'address'
            ],
            [
                'label' => "Departamento de Residencia actual",
                'type' => "select2",
                'name' => 'current_dep_id', // the column that contains the ID of that connected entity
                'entity' => 'current_department', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Department", // foreign key model
                'box'=>'address'
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
                'linked_name'=>'current_dep_id',
                'box'=>'address'
            ],
            [
                'label' => "Pais de Residencia actual",
                'type' => "select2",
                'name' => 'current_country_id', // the column that contains the ID of that connected entity
                'entity' => 'current_country', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Country", // foreign key model
                'box'=>'address'
            ],
            [
                'name'=>'phone',
                'label'=>'Número de teléfono',
                'type'=>'text',
                'box'=>'address'
            ],
            [
                'name'=>'mobile',
                'label'=>'Número celular',
                'type'=>'text',
                'box'=>'address'
            ],
            [
                'name'=>'profession_id',
                'label'=>'Profesión',
                'type'=>'select2',
                'entity'=>'profession',
                'attribute'=>'name',
                'model'=>'App\Models\Profession',
                'box'=>'general'
            ],
            [       // Select2Multiple = n-n relationship (with pivot table)
                'label' => "Habilidades",
                'type' => 'select2_multiple',
                'name' => 'skills', // the method that defines the relationship in your Model
                'entity' => 'skills', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Skill", // foreign key model
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'box'=>'others'
            ],
            [
                'label'=>'Resumen',
                'type'=>'textarea',
                'name'=>'resume',
                'hint'=>'Cuentenos sobre usted',
                'box'=>'others',
                'attributes'=>[
                    'rows'=>15
                ]
            ],
            [
                'label'=>'Evidencias',
                'name'=>'attachments',
                'box'=>'attachments',
                'upload' => true,
                'type' => 'dropzone', // voodoo magic
                'prefix' => '/uploads/', // upload folder (should match the driver specified in the upload handler defined below)
                'upload-url' => url('/curriculum/media-dropzone'), // POST route to handle the individual file uploads
            ],

        ]);



        $this->crud->child_resource_included = ['angular'=>false,'select' => true, 'number' => false];
        $this->crud->child_resource_initialized = ['select' => false, 'number' => false];

        $this->crud->addField([
            'name' => 'educations',
            'label' => 'Estudios',
            'type' => 'stack',
            'view' => 'education',
            'box'=>'educations',
            'entity_singular' => 'educación', // used on the "Add X" button
            'fields' => [
                [
                    'type' => 'select',
                    'name' => 'type_id',
                    'attribute' => 'name',
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
            'type' => 'stack',
            'box'=>'experience',
            'entity_singular' => 'experencia', // used on the "Add X" button
            'view' => 'experience',
            'size'=>11,
            'max' => 12, // maximum rows allowed in the table
            'min' => 0, // minimum rows allowed in the table
            'fields' => [
                [
                    'label' => 'empresa',
                    'type' => 'select',
                    'name' => 'company_id',
                    'entity' => 'type',
                    'attribute' => 'name',
                    'size' => '3',
                    'model' => "App\Models\Company"
                ],
                [
                    'label' => 'sector',
                    'type' => 'select',
                    'name' => 'sector_id',
                    'entity' => 'type',
                    'attribute' => 'name',
                    'size' => '3',
                    'model' => "App\Models\CompanySector"
                ],
            ]
        ]);

        $this->crud->addField([
            'name' => 'languages',
            'label' => 'Idiomas',
            'type' => 'stack',
            'box'=>'languages',
            'child_pivot'=>'proficency',
            'view'=>'language',
            'entity_singular' => 'idioma', // used on the "Add X" button
            'fields' => [
                [
                    'label' => 'Idioma',
                    'type' => 'select',
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
            'box'=>'familiarref',
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
            'box'=>'personalref',
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

        if ($request->input('user_id')!=Auth::user()->id && !Auth::user()->isAdmin()){
            return redirect('/');
        }


        if (empty ($request->get('attachments'))) {
            $this->crud->update(\Request::get($this->crud->model->getKeyName()), ['attachments' => '[]']);
        }

        return $this->updateCrud($request); // TODO: Change the autogenerated stub

    }

    public function handleDropzoneUpload(DropzoneRequest $request)
    {
        $disk = "uploads"; //
        $destination_path = "media";
        $file = $request->file('file');

        try
        {
            $orig_filename=$file->getClientOriginalName();
            $filename=$file->store($destination_path,$disk);

            return response()->json(['success' => true, 'filename' => $orig_filename.'|'.$filename]);
        }
        catch (\Exception $e)
        {
            if (empty ($image)) {
                return response('Not a valid image type', 412);
            } else {
                return response('Unknown error', 412);
            }
        }
    }





    public function performSaveAction($itemId = null)
    {

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
                $redirectUrl = url('curriculum/'.$itemId);
                break;
        }
        return \Redirect::to($redirectUrl);
    }

    public function getSaveAction(){
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

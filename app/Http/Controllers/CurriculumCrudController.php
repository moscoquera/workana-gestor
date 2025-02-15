<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curriculum\CreateCurriculumRequest;
use App\Models\Curriculum;
use App\Models\CurriculumEducation;
use App\Models\EducationalInstitution;
use App\Models\Profession;
use App\Models\PublicUser;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\Exception\AccessDeniedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Backpack\CRUD\app\Http\Controllers\CrudFeatures\SaveActions;
use Illuminate\Routing\Route;
use Barryvdh\DomPDF\Facade as PDF;
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
        $this->crud->setRoute('curriculums');
        $this->crud->setEntityNameStrings('curriculum','curriculums');

        $this->crud->setCreateView('curriculum.create');
        $this->crud->setEditView('curriculum.edit');


        $this->crud->addClause('rightJoin','users as cu','curriculums.user_id','cu.id');
        $this->crud->addClause('leftJoin','users as cl','cu.leader_id','cl.id');
        $this->crud->addClause('where','cu.rol_id','=',2);
        $this->crud->addClause('leftJoin','levels','cu.level_id','levels.id');
        $this->crud->addClause('leftJoin','professions','cu.profession_id','professions.id');
        $this->crud->addClause('selectRaw',"curriculums.id,cu.id as user_id,cu.username, cu.first_name,cu.last_name,LCASE(cu.email) as email, levels.name as level_name,professions.name as profession_name, concat(cl.first_name,' ',cl.last_name) as leader_name");


        $this->crud->removeAllButtonsFromStack('line');

        $this->crud->setColumns([
            [
                'label' => '# Documento',
                'name' => 'username',
            ],
            [
                'label' => 'Nombres',
                'name' => 'first_name'
            ],
            [
                'label' => 'Apellidos',
                'name' => 'last_name'
            ],
            'email',
            [
                'label' => 'Perfíl',
                'name' => 'level_name',
            ],
            [
                'label' => 'Profesión',
                'name' => 'profession_name',
            ],
            [
                'label' => 'Líder',
                'name' => 'leader_name',
            ]
        ]);

        $this->crud->addButtonFromModelFunction('line','curriculum','crudHasCurriculum','beginning');


        $this->crud->allowAccess(['list','create','update']);
        $this->crud->denyAccess(['delete']);

        /*else if (Auth::check() && !Auth::user()->curriculum){
            $this->crud->allowAccess('create');
        }else if (Auth::check() && Auth::user()->curriculum){
            $this->crud->allowAccess(['update','show']);
            $this->crud->setShowView('curriculum.show');
        }*/

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



        $puser = User::find($this->request->input('user_id'));
        if($puser){
            $this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=> $puser->id,
                    'box'=>'personal'
                ]);
        }elseif($this->request->curriculum && !is_object($this->request->curriculum)){
            $curriculum = Curriculum::find(intval($this->request->curriculum));
            $this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=> $curriculum->user->id,
                    'box'=>'personal'
                ]);
        }

            /*
            $this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=> $pcurr->user->id,
                    'box'=>'personal'
                ]);
        */

            /*$this->crud->addField(
                ['name'=>'user_id',
                    'type'=>'hidden',
                    'value'=>Auth::user()->id,
                    'box'=>'personal'
            ]);*/


        $this->crud->addFields([
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
                'name'=>'sex',
                'label'=>'Genero',
                'type'=>'select_from_array',
                'options'=>['m'=>'Masculino','f'=>'Femenino'],
                'allows_null' => false,
                'box'=>'personal',

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
                'type' => "select2_linked",
                'name' => 'nationality_id', // the column that contains the ID of that connected entity
                'entity' => 'nationality', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Country", // foreign key model
                'parent_model'=>'App\Models\PublicUser',
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
                'type' => "select2_linked",
                'parent_model'=>'App\Models\PublicUser',
                'name' => 'current_dep_id',
                'entity' => 'current_department', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Department", // foreign key model
                'box'=>'address'
            ],
            [
                // 1-n relationship
                'label' => "Ciudad de Residencia actual", // Table column heading
                'type' => "select2_from_ajax_linked",
                'parent_model'=>'App\Models\PublicUser',
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
                'type' => "select2_linked",
                'parent_model'=>'App\Models\PublicUser',
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
                'name'=>'mobile2',
                'label'=>'Número celular alternativo',
                'type'=>'text',
                'box'=>'address'
            ],
            [
                'name'=>'profession_id',
                'label'=>'Profesión',
                'type'=>'select2_linked',
                'entity'=>'profession',
                'attribute'=>'name',
                'model'=>'App\Models\Profession',
                'parent_model'=>'App\Models\PublicUser',
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
                'upload-url' => url('/curriculums/media-dropzone'), // POST route to handle the individual file uploads
            ],

        ]);

        $this->crud->addField([
            'name'=>'archive',
            'label'=>'Archivo',
            'type'=>'textarea',
            'box'=>'general'
        ]);


            /*$this->crud->addField(
                ['name'=>'archive',
                    'type'=>'hidden',
                    'box'=>'general'
                ]);*/



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
                    'label' => "Título",
                    'type' => "child_select2",
                    'name' => 'profession_id', // the column that contains the ID of that connected entity
                    'entity' => 'title', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => Profession::class,
                ],
                [
                    'label' => "Institución",
                    'type' => "child_select2",
                    'name' => 'educational_institution_id', // the column that contains the ID of that connected entity
                    'entity' => 'institution', // the method that defines the relationship in your Model
                    'attribute' => "fullname", // foreign key attribute that is shown to user
                    'model' => EducationalInstitution::class,

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

        /*if($request->user()->curriculum){
            return redirect('/');
        }*/
        return $this->storeCrud($request);

    }

    public function update(CreateCurriculumRequest $request)
    {
        //$request->input('user_id')!=Auth::user()->id &&
        if (!Auth::user()->isAdmin()){
            return redirect('/');
        }


        if (empty ($request->get('attachments'))) {
            $request->merge( ['attachments' => '[]']);
        }

        return $this->updateCrud($request);

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
                $redirectUrl = url($this->crud->route);
                break;
        }
        return \Redirect::to($redirectUrl);
    }

    public function getSaveAction(){
        $saveAction = session('save_action', config('backpack.crud.default_save_action', 'save_and_back'));
        $saveOptions = [];
        $saveCurrent = [
            'value' => $saveAction,
            'label' => $this->getSaveActionButtonName($saveAction),
        ];

        switch ($saveAction) {
            case 'save_and_edit':
                $saveOptions['save_and_back'] = $this->getSaveActionButtonName('save_and_back');
                break;
            case 'save_and_back':
            default:
                $saveOptions['save_and_edit'] = $this->getSaveActionButtonName('save_and_edit');
                break;
        }

         /*   $saveOptions = [];
            $saveCurrent = [
                'value' => 'save_and_edit',
                'label' => $this->getSaveActionButtonNameTrait('save_and_edit'),
            ];
        */

        return [
            'active' => $saveCurrent,
            'options' => $saveOptions,
        ];
    }

    public function create()
    {
        try{
            $puser = User::find($this->request->input('user_id'));
            if($puser) {
                $this->crud->create_fields['photo']['value']=$puser->photo;
                $this->crud->create_fields['sex']['value']=$puser->sex;
                $this->crud->create_fields['date_of_birth']['value']=$puser->date_of_birth;
                $this->crud->create_fields['nationality_id']['value']=$puser->nationality_id;
                $this->crud->create_fields['current_address']['value']=$puser->current_address;
                $this->crud->create_fields['current_dep_id']['value']=$puser->current_dep_id;
                $this->crud->create_fields['current_city_id']['value']=$puser->current_city_id;
                $this->crud->create_fields['current_country_id']['value']=$puser->current_country_id;
                $this->crud->create_fields['phone']['value']=$puser->phone;
                $this->crud->create_fields['mobile']['value']=$puser->mobile;
                $this->crud->create_fields['profession_id']['value']=$puser->profession_id;
                $this->crud->create_fields['document']['value']=$puser->username;

            }

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
            if (!Auth::user()->isAdmin()) {
                return redirect('/');
            }
            return view('curriculum.show', ['curriculum' => $curriculum,'crud'=>$this->crud]);
        } catch (ModelNotFoundException $mnfe) {
            return parent::show($id);
        }
    }

    public function export($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            $pdf = PDF::loadView('curriculum.pdf', ['curriculum' => $curriculum,'show'=>true]);
            return $pdf->stream('curriculum_'.$id.'.pdf');
         //   return view('curriculum.pdf', ['curriculum' => $curriculum,'show'=>true]);
        } catch (ModelNotFoundException $mnfe) {
            return parent::show($id);
        }
    }

    public function attachments(Curriculum $curriculum){

    return view('curriculum.attachments',compact('curriculum'));
    }

    public function index()
    {
        $this->crud->removeButtonFromStack('create','top');
        return parent::index(); // TODO: Change the autogenerated stub
    }

}

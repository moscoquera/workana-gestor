<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateUserCrudRequest;
use App\Models\PublicUser;
use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\Users\CreateUserCrudRequest;
use Yajra\DataTables\Html\Builder;

class UserCrudController extends CrudController
{

    protected $htmlBuilder;

    public function __construct(Builder $htmlBuilder)
    {
        parent::__construct();
        $this->htmlBuilder = $htmlBuilder;
    }


    public function setup()
    {
        $this->crud->setModel('App\Models\PublicUser');
        $this->crud->setRoute('users');
        $this->crud->setEntityNameStrings('usuario','usuarios');
        $this->crud->allowAccess('list');

        $this->crud->setColumns([
            [
                'label'=>'# documento',
                'name'=>'username',
            ],
            [
                'label'=>'Nombres',
                'name'=>'first_name'
            ],
            [
                'label'=>'Apellidos',
                'name'=>'last_name'
            ],
            'email',
            [
                'label'=>'perfíl',
                'name'=>'level',
                'type'=>'select',
                'entity' => 'level', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Level" // foreign key model
            ],
            [
                'label'=>'Profesión',
                'name'=>'profession',
                'type'=>'select',
                'entity'=>'profession',
                'attribute'=>'name',
                'model'=>'App.Models.Profession'
            ],
            [
                'label'=>'Líder',
                'name'=>'leader',
                'type'=>'select',
                'entity'=>'leader',
                'attribute'=>'fullname',
                'model'=>PublicUser::class,
            ]
        ]);

        $this->crud->addFields(
            [
                [
                    'name'=>'username',
                    'label'=>'# de documento'
                ],
                [
                    'name'=>'first_name',
                    'label'=>'Nombres',
                ],
                [
                    'name'=>'last_name',
                    'label'=>'Apellidos',
                ],
                [
                    'label'=>'email',
                    'name'=>'email',
                    'hint'=>'opcional'
                ],
                [  // Select2
                    'label' => "Perfíl",
                    'type' => 'select2',
                    'name' => 'level_id', // the db column for the foreign key
                    'entity' => 'level', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'model' => "App\Models\Level" // foreign key model
                ],
                [
                    'name'=>'sex',
                    'label'=>'Genero',
                    'type'=>'select_from_array',
                    'options'=>['m'=>'Masculino','f'=>'Femenino'],
                    'allows_null' => false,
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
                    'name'=>'current_address',

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
                    'linked_name'=>'current_dep_id',

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
                    'model'=>'App\Models\Profession',
                    'box'=>'general'
                ],
                [
                    'name'=>'leader_id',
                    'label'=>'Líder',
                    'type'=>'select2',
                    'entity'=>'leader',
                    'attribute'=>'fullname',
                    'model'=>PublicUser::class,
                ],
                [
                    'label'=>'Lugar de votación',
                    'type'=>'textarea',
                    'name'=>'election_address',

                ],
                [
                    'label' => "Departamento de votación",
                    'type' => "select2",
                    'name' => 'election_dep_id', // the column that contains the ID of that connected entity
                    'entity' => 'election_department', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\Department", // foreign key model

                ],
                [
                    // 1-n relationship
                    'label' => "Ciudad de votación", // Table column heading
                    'type' => "select2_from_ajax_linked",
                    'name' => 'election_city_id', // the column that contains the ID of that connected entity
                    'entity' => 'election_city', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\City", // foreign key model
                    'data_source' => url("api/city"), // url to controller search function (with /{id} should return model)
                    'placeholder' => "Seleccione la ciudad de votación", // placeholder for the select
                    'minimum_input_length' => 2, // minimum characters to type before querying results
                    'linked_name'=>'election_dep_id',
                ],


            ]
        ,'both');




        $this->crud->addField([
            'fake'=>true,
            'name'=>'passwordchange',
            'label'=>'Cambiar contraseña',
            'type'=>'checkbox',

        ],'update');

        $this->crud->addField([
            'name'=>'password',
            'label'=>'Contraseña',
            'type'=>'password',

        ],'update');
        $this->crud->addField([
            'name'=>'password_confirmation',
            'fake'=>true,
            'label'=>'Confirmar contraseña',
            'type'=>'password',

        ],'update');

        $this->crud->addButtonFromModelFunction('line','curriculum','crudHasCurriculum','beginning');
        $this->crud->addButtonFromModelFunction('line','dashboard','crudDashboard','beginning');

    }


    public function store(CreateUserCrudRequest $request)
    {
        $request['password']=bcrypt($request['username']);
        $request['rol_id']=2;
        return parent::storeCrud($request);
    }

    public function update(UpdateUserCrudRequest $request)
    {
        if ($request->input('passwordchange')=="1" && $request->input('password')){
            $request['password']=bcrypt($request['password']);
        }else{
            unset($request['password']);
        }

        return parent::updateCrud($request);
    }


    public function show($id)
    {

        $user = PublicUser::findOrFail($id);
        $visitsBuilder = app()->make(Builder::class);
        $eventsBuilder = app()->make(Builder::class);
        $visitsBuilder->addColumn([
                    'data'=>'dateandtime',
                    'name'=>'visit.dateandtime',
                    'title'=>'Fecha'
                ])
            ->addColumn([
                'data'=>'attended',
                'name'=>'attended',
                'title'=>'Asistió?'
            ])
            ->addColumn([
                'data'=>'address',
                'name'=>'visit.address',
                'title'=>'Lugar'
            ])
            ->addColumn([
                'data'=>'description',
                'name'=>'visit.description',
                'title'=>'Descripción'
            ])
            ->addColumn([
                'data'=>'comments',
                'name'=>'visit.comments',
                'title'=>'Comentarios'
            ])->parameters([
                'language' => [
                    'url' => url(url('vendor/datatables/Spanish.json')),//<--here
                ],
                'order'=>[0,'desc']
                // other configs
            ])->setTableAttribute('id','dtVisits')
            ->ajax(route('api.user.visits',['user'=>$id]));

        $eventsBuilder->addColumn([
            'data'=>'dateandtime',
            'name'=>'event.dateandtime',
            'title'=>'Fecha'
        ])->addColumn([
            'data'=>'name',
            'name'=>'event.name',
            'title'=>'Nombre del evento'
        ])->addColumn([
                'data'=>'attended',
                'name'=>'attended',
                'title'=>'Asistió?'
            ])
            ->addColumn([
                'data'=>'address',
                'name'=>'event.address',
                'title'=>'Lugar'
            ])->parameters([
                'language' => [
                    'url' => url(url('vendor/datatables/Spanish.json')),//<--here
                ],
                'order'=>[0,'desc']
                // other configs
            ])->setTableAttribute('id','dtEvents')
            ->ajax(route('api.user.events.asistance',['user'=>$id]));

        $totalEventsInvitations=$user->attendanceToEvents()->count();
        $totalEventsAttended=$user->attendanceToEvents()->where('attended',1)->count();
        $eventAttendanceChart = Charts::create('bar','highcharts')->title('Asistencia a eventos')
            ->labels(['asistidos','sin asistir'])
            ->values([$totalEventsAttended,$totalEventsInvitations-$totalEventsAttended])->dimensions(0,300);

        return view('users.dashboard',[
            'charts'=>[
                'event_attendance'=>$eventAttendanceChart
            ],
            'user'=>$user,
            'tables'=>[
                'visits'=>$visitsBuilder,
                'events'=>$eventsBuilder,
            ]
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceCrudRequest;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\PublicUser;
use App\Models\TempUser;
use App\Traits\NestedRouteBadParameterBug;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;
use Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;



class AttendanceCrudController extends CrudController
{

    use NestedRouteBadParameterBug;

    public function setup()
    {

        $event= Route::current()->parameters['event'];
        $this->crud->setModel('App\Models\Attendance');
        if(is_object($event)){
            $this->crud->setRoute('events/'.$event->id.'/attendance');
        }else{
            $this->crud->setRoute('events/'.$event.'/attendance');
            $event=Event::find($event);
        }

        $this->crud->title="Lista de asistencia para el evento: ".$event->name;
        View::share('custom_page_title',"Lista de asistencia para el evento: ".$event->name);

        $this->crud->list_order=[[2,'desc']];
        $this->crud->setListView('vendor.backpack.crud.attendancelist');

        $this->event=$event;

        $this->crud->addClause('where','attendable_id',$event->id);
        $this->crud->addClause('where','attendable_type',Event::class);


        $this->crud->setEntityNameStrings('invitación', 'invitaciones');

        $this->crud->addButton('top','attendance_masive_add','view','vendor.backpack.crud.buttons.event_attendance_masive');
//        $this->crud->addButton('top','attendance_excel','view','vendor.backpack.crud.buttons.event_attendance_excel');
        $this->crud->enableExportButtons();

        $this->crud->addColumns([
            [
                // 1-n relationship
                'label' => "Perfíl", // Table column heading
                'type' => "select",
                'name' => 'attende_level', // the column that contains the ID of that connected entity;
                'entity' => 'attende', // the method that defines the relationship in your Model
                'attribute' => "level.name", // foreign key attribute that is shown to user

            ],
            [
                // 1-n relationship
                'label' => "# Documento", // Table column heading
                'type' => "select",
                'name' => 'attende_document', // the column that contains the ID of that connected entity;
                'entity' => 'attende', // the method that defines the relationship in your Model
                'attribute' => "document", // foreign key attribute that is shown to user

            ],
            [
                // 1-n relationship
                'label' => "Nombre completo", // Table column heading
                'type' => "select",
                'name' => 'attende_name', // the column that contains the ID of that connected entity;
                'entity' => 'attende', // the method that defines the relationship in your Model
                'attribute' => "fullname", // foreign key attribute that is shown to user

            ],
            [
                // 1-n relationship
                'label' => "Email", // Table column heading
                'type' => "select",
                'name' => 'attende_email', // the column that contains the ID of that connected entity;
                'entity' => 'attende', // the method that defines the relationship in your Model
                'attribute' => "email", // foreign key attribute that is shown to user

            ],
            [
                'label'=>'Asistió?',
                'type'=>'active_toggle_switch',
                'name'=>'attended',
                'switch_labels'=>[
                    'on'=>'Si',
                    'off'=>'No'
                ]
            ]
        ]);


        $attendance_id=-1;
        if (isset(Route::current()->parameters['attendance']) && Route::current()->parameters['attendance']){
            $attendance_id=intval(Route::current()->parameters['attendance']);
        }

        $publicUsersQuery=DB::table('users')->whereNotExists(function ($query) use($event,$attendance_id){
            return $query->select(DB::raw(1))->from('attendances')
                ->where('attendable_id',$event->id)->whereRaw('users.id = attende_id')
                ->where('id','!=',$attendance_id)
                ->where('attendable_type','App\\Models\\Event')->where('attende_type','App\\Models\\PublicUser');
        })->whereIn('level_id',$event->levels()->pluck('id'))
            ->select('id','first_name','last_name','email','username')->selectRaw("'App\\\\Models\\\\PublicUser' as attende_type");

        $fullquery=$publicUsersQuery;

        if(!$event->controlled) {
            $tmpUsersQuery = DB::table('temp_users')->whereNotExists(function ($query) use ($event, $attendance_id) {
                return $query->select(DB::raw(1))->from('attendances')
                    ->where('attendable_id', $event->id)->whereRaw('temp_users.id = attende_id')
                    ->where('id', '!=', $attendance_id)
                    ->where('attendable_type', 'App\\Models\\Event')->where('attende_type', 'App\\Models\\TempUser');
            })->select('id', 'first_name', 'last_name', 'email', 'document')->selectRaw("'App\\\\Models\\\\TempUser' as attende_type");

            $fullquery = $publicUsersQuery->union($tmpUsersQuery);
        }
        $fullquery=$fullquery->get()->mapWithKeys(function($item){
            $kprefix='';
            if($item->attende_type=='App\Models\PublicUser'){
                $kprefix='p_';
            }elseif($item->attende_type=='App\Models\TempUser'){
                $kprefix='t_';
            }
            return [$kprefix.strval($item->id) => $item->first_name.' '.$item->last_name];
        });
        $this->crud->addFields(
            [
                [  // Select2
                    'label' => "Invitado",
                    'type' => 'select2_from_array',
                    'name' => 'attende_id', // the db column for the foreign key
                    'entity' => 'attende', // the method that defines the relationship in your Model
                    'attribute' => 'fullname', // foreign key attribute that is shown to user
                    'options' => $fullquery,
                ],
                [
                    'label'=>'Asistió?',
                    'name'=>'attended',
                    'type' => 'toggle_switch',
                    'switch_labels'=>[
                        'on'=>'Si',
                        'off'=>'No'
                    ]
                ]
            ]
        );




        View::share('event',$event);


    }


    public function update(AttendanceCrudRequest $request){
        return $this->updateCrud($request);
    }

    public function store(AttendanceCrudRequest $request){
        $attende_id=explode('_',$request->input('attende_id'));
        $attende_type=$attende_id[1];
        switch ($attende_id[0]){
            case 't':
                $attende_type='App\\Models\\TempUser';
                break;
            case 'p':
                $attende_type='App\\Models\\PublicUser';
                break;
        }
        $request->merge([
            'attendable_id'=>$this->event->getKey(),
            'attendable_type'=>Event::class,
            'attende_id'=>$attende_id[1],
            'attende_type'=>$attende_type
        ]);

        return $this->storeCrud($request);
    }


    public function Import(Event $event){
        $availableLevels = $event->levels->keyBy('id');
        $levels=[];
        foreach ($this->request->input('levels') as $level){
            if (isset($availableLevels[$level])){
                array_push($levels,$level);
            }
        }
        $usersIds=PublicUser::whereIn('level_id',$levels)->pluck('id');
        $already=$event->attendance()->pluck('attende_id');
        $new=$usersIds->diff($already)->map(function($val){
            return new Attendance([
                'attende_id'=>$val,
                'attende_type'=>'App\Models\PublicUser',
                'attended'=>0
            ]);
        });
        $event->attendance()->saveMany($new);
        \Alert::success('Usuarios añadidos correctamente')->flash();
        return redirect($this->crud->route);

    }

    public function attended($request){
        $validator = Validator::make($this->request->all(),[
            'id'=>'required|integer|exists:attendances',
            'checked'=>'required|boolean',
        ]);

        if (!$validator->passes()){
            return response()->json(['error'=>$validator->errors()->all(),'data'=>$this->request->all()]);
        }

         $id=$this->request->input('id');
         $cheked=$this->request->input('checked');
         $attendance_reg = Attendance::find($id);
         $attendance_reg->attended=$cheked;
         $attendance_reg->save();
        return response()->json([
            'success'=>'ok'
        ],200);
    }





}

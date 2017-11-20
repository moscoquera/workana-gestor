<?php

namespace App\Http\Controllers;

use App\Http\Requests\Events\CreateEventCrudRequest;
use App\Http\Requests\Events\emailRequest;
use App\Http\Requests\Events\UpdateEventCrudRequest;
use App\Mail\rawEmail;
use App\Models\EventStatus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class EventsCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute('events');
        $this->crud->setEntityNameStrings('evento', 'eventos');

        $this->crud->addButton('line','attendance_email','view','vendor.backpack.crud.buttons.event_attendance_email');
        $this->crud->addButton('line','attendance','view','vendor.backpack.crud.buttons.event_attendance');


        $this->crud->addColumns([
            [
                'label'=>'Consecutivo',
                'name'=>'id',

            ],
            [
                'name'=>'name',
                'label'=>'Nombre'
            ],
            [
                'label' => "Tipo",
                'type' => "select",
                'name' => 'type_id',
                'entity' => 'type', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\EventType", // foreign key model
            ],
            [
                'name'=>'dateandtime',
                'label'=>'Fecha y hora',
            ],
            [
                'label' => "Municipio",
                'type' => "select",
                'name' => 'city_id',
                'entity' => 'city', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
            ],
            [
                'label'=>'Nombre del lugar',
                'name'=>'place_name'
            ],
            [
                'name'=>'address',
                'label'=>'Lugar del evento'
            ],
            [
                'name'=>'observations',
                'label'=>'Observaciones'
            ],
            [
                'label' => "Responsable del evento",
                'type' => "select",
                'name' => 'user_id',
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => "fullname", // foreign key attribute that is shown to user
                'model' => "App\Models\PublicUser", // foreign key model
            ],
            [
                'label' => "Estado",
                'type' => "select",
                'name' => 'status_id',
                'entity' => 'status', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\EventStatus", // foreign key model
            ],
        ]);

        $this->crud->addFields(
            [
                [
                    'name'=>'name',
                    'label'=>'Nombre',
                    'type'=>'text'
                ],
                [
                    'label' => "Tipo",
                    'type' => "select2",
                    'name' => 'type_id',
                    'entity' => 'type', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\EventType", // foreign key model
                ],
                [
                    'name'=>'dateandtime',
                    'label'=>'Fecha y hora',
                    'type'=>'datetime_picker',
                    'datetime_picker_options' => [
                        'format' => 'DD/MM/YYYY HH:mm',
                        'language' => 'es'
                    ]
                ],
                [
                    'label' => "Municipio",
                    'type' => "select2",
                    'name' => 'city_id',
                    'entity' => 'city', // the method that defines the relationship in your Model
                    'attribute' => "name", // foreign key attribute that is shown to user
                    'model' => "App\Models\City", // foreign key model
                ],
                [
                    'label'=>'Nombre del lugar',
                    'name'=>'place_name'
                ],
                [
                    'name'=>'address',
                    'label'=>'Lugar del evento',
                    'type'=>'textarea'
                ],
                [
                    'name'=>'observations',
                    'label'=>'Observaciones',
                    'type'=>'ckeditor'
                ],
                [
                    'label'=>'Asistencia controlada',
                    'name'=>'controlled',
                    'type' => 'toggle_switch',
                    'switch_labels'=>[
                        'on'=>'Si',
                        'off'=>'No'
                    ]
                ],
                [
                    'label' => "Responsable del evento",
                    'type' => "select2",
                    'name' => 'user_id',
                    'entity' => 'user', // the method that defines the relationship in your Model
                    'attribute' => "fullname", // foreign key attribute that is shown to user
                    'model' => "App\Models\PublicUser", // foreign key model
                ],
            ]
        );

        $this->crud->addField(
            [
                'label' => "Estado",
                'type' => "select2",
                'name' => 'status_id',
                'entity' => 'status', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\EventStatus", // foreign key model
            ],'update');

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => "Perfiles",
            'type' => 'select2_multiple',
            'name' => 'levels', // the method that defines the relationship in your Model
            'entity' => 'levels', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Level", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
/*
        $this->crud->addField([
           'label'=>'Personas invitadas',
            'type'=>'dual_listbox',
            'name'=>'attendes',
            'model'=>'App\Models\Attendance',
            'source'=>[
                [
                    'model'=>'App\Models\Level',
                    'slug'=>'lvl',
                    'attribute'=>'name',
                    'suffix'=>' (Todos)',
                    'preffix'=>'Perfíl: '
                ],
                [
                    'model'=>'App\Models\PublicUser',
                    'slug'=>'pu',
                    'attribute'=>'fullname',
                    'suffix'=>'',
                    'preffix'=>''
                ],
                [
                    'model'=>'App\Models\TempUser',
                    'slug'=>'pu',
                    'attribute'=>'fullname',
                    'suffix'=>'',
                    'preffix'=>'Externo: '
                ]
            ],
            'dual_settings'=>[
                'nonSelectedListLabel'=> 'Disponibles',
                'selectedListLabel'=> 'Invitados',
                'preserveSelectionOnMove'=> 'false',
                'moveOnSelect'=> false,
                'filterTextClear'=>'Todos',
                'filterPlaceHolder'=>'Filtrar',
                'moveSelectedLabel'=>'Invitar seleccionados',
                'moveAllLabel' =>'Invitarlos a todos',
                'removeSelectedLabel'=>'Remover los seleccionados',
                'removeAllLabel'=>'Removerlos a todos',
                'infoText'=>'Total {0}',
                'infoTextFiltered'=>'<span class="label label-warning">Mostrando</span> {0} de {1}',
                'infoTextEmpty'=>'lista vacia'
            ]
        ]);
*/
    }




    public function store(CreateEventCrudRequest $request){
        $activo=EventStatus::where('name','Activo')->first()->id;
        $request->merge([
            'status_id'=>$activo,
        ]);
        return $this->storeCrud($request);
    }

    public function update(UpdateEventCrudRequest $request){
        return $this->updateCrud($request);
    }

    public function email($id){
        $event = $this->crud->getEntry($id);
        return view('events.email',['event'=>$event]);
    }

    public function sendemail(emailRequest $request,$id)
    {
        $event = $this->crud->getEntry($id);
        $attendes=$event->attendance->map(function($attende){
            return $attende->attende->email;
        })->toArray();
        Mail::bcc($attendes)
            ->send(new rawEmail($request->input('title'),$request->input('message')));
        return redirect(URL::current())->withInput()->with('success','email enviado correctamente');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\visitCrudRequest;
use App\Models\VisitStatus;
use App\Models\VisitSubject;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Http\Requests\DropzoneRequest;

class visitsCrudController extends CrudController
{


    public function setup()
    {
        $this->crud->setModel('App\Models\Visit');
        $this->crud->setRoute('visits');
        $this->crud->setEntityNameStrings('cita', 'citas');

        $this->crud->child_resource_included = ['angular'=>false,'select' => true, 'number' => false];
        $this->crud->child_resource_initialized = ['select' => false, 'number' => false];


        $this->crud->addColumns([
            [
                'label'=>'ID',
                'name'=>'id',
            ],
            [
                'label'=>'Fecha y hora',
                'name'=>'dateandtime',
            ],
            [  // Select2
                'label' => "Asunto",
                'type' => 'select',
                'name' => 'subject_id',
                'entity' => 'subject',
                'attribute' => 'name',
                'model' => VisitSubject::class,
            ],
            [
                'label'=>'Lugar',
                'name'=>'address',
            ],
            [
                'label'=>'Descripción',
                'name'=>'description'
            ],
            [
                'label'=>'Asistentes',
                'name'=>'attendance_column',
                'type' => "model_function",
                'function_name' => 'getAttendanceColumnAttribute', // the method in your Model
            ],
            [  // Select2
                'label' => "Resultado",
                'type' => 'select',
                'name' => 'result_id',
                'entity' => 'result',
                'attribute' => 'name',
                'model' => VisitStatus::class,
            ],
            [   // date_picker
                'name' => 'next_visit',
                'type' => 'date_picker',
                'label' => 'Proxima visita',
            ],
            [
                'name'=>'attachments',
                'type'=>'attachments',
                'label'=>'Adjuntos'
            ]

        ]);

        $this->crud->addFields([
            [
                'label'=>'Fecha y hora',
                'name'=>'dateandtime',
                'type'=>'datetime_picker'
            ],
            [  // Select2
                'label' => "Asunto",
                'type' => 'select2',
                'name' => 'subject_id',
                'entity' => 'subject',
                'attribute' => 'name',
                'model' => VisitSubject::class,
            ],
            [
                'label'=>'Lugar',
                'name'=>'address',
                'type'=>'text'
            ],
            [
                'label'=>'Descripción',
                'name'=>'description',
                'type'=>'textarea'
            ],
            [
                'label'=>'Comentarios',
                'name'=>'comments',
                'type'=>'textarea'
            ],
            [  // Select2
                'label' => "Resultado",
                'type' => 'select2',
                'name' => 'result_id',
                'entity' => 'result',
                'attribute' => 'name',
                'model' => VisitStatus::class,
            ],
            [   // date_picker
                'name' => 'next_visit',
                'type' => 'date_picker',
                'label' => 'Proxima visita',
                // optional:
                'date_picker_options' => [
                    'todayBtn' => true,
                    'format' => 'yyyy-mm-dd',
                    'language' => 'es'
                ],
            ],
            [
                'name' => 'attendance',
                'label' => 'Asistentes',
                'type' => 'child',
                'entity_singular' => 'asistente', // used on the "Add X" button
                'columns' => [
                    [
                        'label' => "Nombre",
                        'type' => "child_select2",
                        'name' => 'attende_id', // the column that contains the ID of that connected entity
                        'entity' => 'attende', // the method that defines the relationship in your Model
                        'attribute' => "fullname", // foreign key attribute that is shown to user
                        'model' => "App\Models\PublicUser", // foreign key model

                    ],

                ],
                'max' => 100, // maximum rows allowed in the table
                'min' => 1 // minimum rows allowed in the table
            ],
            [
                'label'=>'Adjuntos',
                'name'=>'attachments',
                'upload' => true,
                'type' => 'dropzone', // voodoo magic
                'prefix' => '/uploads/', // upload folder (should match the driver specified in the upload handler defined below)
                'upload-url' => url('/visit/media-dropzone'), // POST route to handle the individual file uploads
            ],


        ]);

    }


    public function store(visitCrudRequest  $request){
        return $this->storeCrud($request);
    }


    public function update(visitCrudRequest  $request){


        if (empty ($request->get('attachments'))) {
            $this->crud->update(\Request::get($this->crud->model->getKeyName()), ['attachments' => '[]']);
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

}

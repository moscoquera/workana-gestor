<?php

namespace App\Http\Controllers\Users;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Events\emailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\rawEmail;
use Illuminate\Support\Facades\URL;

class birthdaysCrudController extends CrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\PublicUser');
        $this->crud->setRoute('birthdays');
        $this->crud->setEntityNameStrings('cumpleaño', 'cumpleaños');
        $this->crud->denyAccess(['create','update','delete']);
        $this->crud->addClause('selectRaw','users.*');
        $this->crud->addClause('whereRaw','month(users.date_of_birth) = month(CURDATE())');

        $this->crud->addColumns([
            [
                // 1-n relationship
                'label' => "Fecha del cumpleaños", // Table column heading
                'name' => 'birthday', // the column that contains the ID of that connected entity;

            ],
            [
                'label'=>'Nombre completo',
                'name'=>'fullname'
            ]
        ]);

        $this->crud->addButton('line','email','view','vendor.backpack.crud.buttons.send_birthday_email');

    }

    public function email($id){
        $user = $this->crud->getEntry($id);
        return view('events.birthday',['user'=>$user]);
    }

    public function sendemail(emailRequest $request,$id)
    {
        $user = $this->crud->getEntry($id);
        Mail::to($user->email)
            ->send(new rawEmail($request->input('title'),$request->input('message')));
        return redirect(URL::current())->withInput()->with('success','email enviado correctamente');
    }

}

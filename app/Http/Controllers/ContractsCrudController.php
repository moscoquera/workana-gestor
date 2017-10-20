<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contracts\ProfessionalSearch;
use App\Models\Profession;
use App\Models\PublicUser;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractsCrudController extends CrudController
{

    public function setup(){

        $this->crud->setModel('App\Models\Contract');
        $this->crud->setRoute('contracts');
        $this->crud->setEntityNameStrings('contrato','contratos');

        $this->crud->allowAccess('find');
    }


    public function find(Request $request){

        $this->crud->hasAccessOrFail('find');

        return view('contracts.find',['crud'=>$this->crud]);
    }

    public function findpost(ProfessionalSearch $request){
        $professions = $request->input('professions');
        $hired = $request->input('hired');

        $users = PublicUser::with('curriculum')->join('curriculums','users.id','=','curriculums.user_id');

        if (!$hired)
            $users->whereNotExists(function($query){
               $query->select(DB::raw(1))->from('contracts')->where('users.id','=','contracts.user_id');
            });


        if ($professions){
            $users=$users->whereExists(function($query) use($professions){
                $query->select(DB::raw(1))
                    ->from('professions')
                    ->whereIn('curriculums.profession_id',$professions);
            });
        }



        $professions=Profession::all();
        $users=$users->get();
        return view('contracts.find',['crud'=>$this->crud,'users'=>$users,'professions'=>$professions]);
    }

}

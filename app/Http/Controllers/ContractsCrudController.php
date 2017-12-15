<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contracts\ContractCrudRequest;
use App\Http\Requests\Contracts\ProfessionalSearch;
use App\Models\Profession;
use App\Models\PublicUser;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ContractsCrudController extends CrudController
{

    public function setup()
    {

        $this->crud->setModel('App\Models\Contract');
        $this->crud->setRoute('contracts');
        $this->crud->setEntityNameStrings('contrato', 'contratos');

        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'Consecutivo'
            ],
            [
                // 1-n relationship
                'label' => "Tipo", // Table column heading
                'type' => "select",
                'name' => 'type_id', // the column that contains the ID of that connected entity;
                'entity' => 'type', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\ContractType", // foreign key model,

            ],
            [
                // 1-n relationship
                'label' => "Contratista", // Table column heading
                'type' => "select",
                'name' => 'user_id', // the column that contains the ID of that connected entity;
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => "fullname", // foreign key attribute that is shown to user
                'model' => "App\Models\PublicUser", // foreign key model
            ],
            [
                'name' => 'start_date',
                'label' => 'Fecha de inicio'
            ],
            [
                'name' => 'end_date',
                'label' => 'Fecha de fin'
            ],
            [
                'label' => 'Descripción',
                'name' => 'description'
            ],
            [
                'label' => 'Fecha de creación del contrato',
                'name' => 'created_at'
            ]
        ]);

        $this->crud->addFields([
            [  // Select2
                'label' => "Contratista",
                'type' => 'select2',
                'name' => 'user_id', // the db column for the foreign key
                'entity' => 'user', // the method that defines the relationship in your Model
                'attribute' => 'fullname', // foreign key attribute that is shown to user
                'model' => "App\Models\PublicUser", // foreign key model

            ],
            [  // Select2
                'label' => "Tipo de contrato",
                'type' => 'select2',
                'name' => 'type_id', // the db column for the foreign key
                'entity' => 'type', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\ContractType" // foreign key model
            ],
            [
                'label' => 'Periodo de contratación:',
                'type' => 'date_range',
                'name' => 'contract_time',
                'start_name' => 'start_date',
                'end_name' => 'end_date',
                'start_default' => date('Y-m-d'),
                'end_default' => date('Y-m-d'),
                'date_range_options' => [
                    "locale" => [
                        "format" => "YYYY-MM-DD",
                        "separator" => " - ",
                        "applyLabel" => "Aplicar",
                        "cancelLabel" => "Cancelar",
                        "fromLabel" => "De",
                        "toLabel" => "A",
                        "customRangeLabel" => "Personalizado",
                        "weekLabel" => "S",
                        "daysOfWeek" => [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames" => [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay" => 1
                    ]
                ]
            ],
            [
                'label'=>'Descripción',
                'type'=>'textarea',
                'name'=>'description',

            ]
        ]);

        $this->crud->allowAccess('find');


    }

    public function create()
    {
        $uid=$this->request->input('user');
        if($uid){
            $this->crud->create_fields['user_id']['value']=$uid;
        }
        return parent::create(); // TODO: Change the autogenerated stub
    }

    public function Store(ContractCrudRequest $request){
        return $this->storeCrud($request);
    }

    public function Update(ContractCrudRequest $request){
        return $this->updateCrud($request);
    }

    public function find(Request $request)
    {

        $this->crud->hasAccessOrFail('find');

        return view('contracts.find', ['crud' => $this->crud]);
    }

    public function findpost(ProfessionalSearch $request)
    {

        $users=$this->find_process($request);
        $professions = Profession::all();
        $queryArgs=$request->input();
        return view('contracts.find', ['crud' => $this->crud, 'users' => $users, 'professions' => $professions,'queryArgs'=>$queryArgs]);
    }

    public function export(ProfessionalSearch $request){
        $users=$this->find_process($request);
        $professions = Profession::all();


        Excel::create('Busqueda profesionales',function ($excel) use($users){
            $excel->sheet('profesionales',function ($sheet) use ($users){
                $sheet->appendRow(array(
                    '# de documento','Nombre completo','Profesión','Habilidades'
                ));
                foreach ($users as $user){
                    $sheet->appendRow(array(
                        $user->document,
                        $user->fullname,
                        $user->profession->name,
                        join('\n',$user->curriculum->skills->pluck('name')->toArray())
                    ));
                }
            });
        })->export('xls');
    }


    public function find_process(ProfessionalSearch $request){
        $professions = $request->input('professions');
        $skills = $request->input('skills');
        $companies = $request->input('companies');
        $educations = $request->input('educations');
        $sex = $request->input('sex');
        $ages = $request->input('ages');
        $languages = $request->input('languages');
        $cities = $request->input('cities');

        $hired = $request->input('hired');


        $users = PublicUser::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('curriculums')
                ->whereRaw('users.id = curriculums.user_id');
        });

        if (!$hired)
            $users->whereNotExists(function ($query) {
                $query->select(DB::raw(1))->from('contracts')->where('users.id', '=', 'contracts.user_id');
            });


        if ($professions) {
            $users = $users->whereIn('users.profession_id', $professions);
        }
        if ($skills) {
            $users = $users->whereExists(function ($query) use ($skills) {
                $query->select(DB::raw(1))
                    ->from('curriculum_skill')->join('curriculums', 'curriculum_skill.curriculum_id', '=', 'curriculums.id')
                    ->whereRaw('users.id = curriculums.user_id')
                    ->whereIn('curriculum_skill.skill_id', $skills);
            });
        }

        if ($companies) {
            $users = $users->whereExists(function ($query) use ($companies) {
                $query->select(DB::raw(1))
                    ->from('experiences')->join('curriculums', 'experiences.curriculum_id', '=', 'curriculums.id')
                    ->whereRaw('users.id = curriculums.user_id')
                    ->whereIn('experiences.company_id', $companies);
            });
        }


        if ($educations) {
            $users = $users->join('professions','users.profession_id','=','professions.id')->where('professions.type_id',$educations);
        }


        if ($sex) {
            $users = $users->where('users.sex', $sex);
        }
        if ($ages) {
            $ages = explode(',', $ages);
            $ages[0] = intval($ages[0]);
            $ages[1] = intval($ages[1]);
            $users = $users->whereRaw('TIMESTAMPDIFF(YEAR,users.date_of_birth,CURDATE()) >= ' . $ages[0])
                ->whereRaw('TIMESTAMPDIFF(YEAR,users.date_of_birth,CURDATE()) <= ' . $ages[1]);
        }

        if ($languages) {
            $users = $users->whereExists(function ($query) use ($languages) {
                $query->select(DB::raw(1))
                    ->from('curriculum_language')->join('curriculums', 'curriculum_language.curriculum_id', '=', 'curriculums.id')
                    ->whereRaw('users.id = curriculums.user_id')
                    ->whereIn('curriculum_language.language_id', $languages);
            });
        }

        if ($cities) {
            $users = $users->whereIn('users.current_city_id', $cities);
        }

        return $users->with('curriculum')->with('curriculum.skills')->get();
    }

}

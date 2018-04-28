<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Department;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Builder;

class DashboardController extends CrudController
{
    
    public function __construct() {
    
    //    $this->middleware('auth');
    }
    
    function index(){

        if (Auth::user()->isAdmin()){
            $data=[];
            $data['contracts']=[
                'all'=>Contract::count(),
                'active'=>Contract::active()->count(),
                'ended'=>Contract::ended()->count(),
                'nostarted'=>Contract::noStarted()->count(),
            ];

            $cityBuilder = app()->make(Builder::class);
            $leaderBuilder = app()->make(Builder::class);
            $candidatesBuilder = app()->make(Builder::class);
            $cityBuilder->addColumn([
                'data'=>'name',
                'name'=>'name',
                'title'=>'Ciudad'
            ])
                ->addColumn([
                    'data'=>'votes',
                    'name'=>'votes',
                    'title'=>'Votos'
                ])->parameters([
                    'language' => [
                            'url'=>url('vendor/datatables/Spanish.json')
                        ],
                    'order'=>[1,'desc'],
                    'searching'=>false
                    // other configs
                ])->setTableAttribute('id','dtCity')
                ->ajax([
                    'url'=>route('api.election.results.city'),
                    'data'=>"function (d) {
                                        d.year = $('#year').val();
                                        d.department = $('#departments').val();
                                        d.city = $('#cities').val();
                                        d.leader = $('#leaders').val();
                                        d.candidate = $('#candidate').val();
                                        
                                    }",
                ]);

            $leaderBuilder->addColumn([
                'data'=>'fullname',
                'name'=>'fullname',
                'title'=>'Líder'
            ])
                ->addColumn([
                    'data'=>'zoned',
                    'name'=>'zoned',
                    'title'=>'Zonificados'
                ])->addColumn([
                    'data'=>'registered',
                    'name'=>'registered',
                    'title'=>'Planillados'
                ])->addColumn([
                    'data'=>'controlled',
                    'name'=>'controlled',
                    'title'=>'Controlados'
                ])->parameters([
                    'language' => [
                        'url'=>url('vendor/datatables/Spanish.json')
                    ],
                    'order'=>[0,'desc'],
                    'searching'=>false
                    // other configs
                ])->setTableAttribute('id','dtLeaders')
                ->ajax([
                    'url'=>route('api.election.results.leader'),
                    'data'=>"function (d) {
                                        d.year = $('#year').val();
                                        d.department = $('#departments').val();
                                        d.city = $('#cities').val();
                                        d.leader = $('#leaders').val();
                                        d.candidate = $('#candidate').val();
                                        
                                    }",
                ]);


            $candidatesBuilder->addColumn([
                'data'=>'name',
                'name'=>'name',
                'title'=>'Candidato'
            ])->addColumn([
                    'data'=>'proyected_votes',
                    'name'=>'proyected_votes',
                    'title'=>'Votos proyectados'
                ])->addColumn([
                    'data'=>'gotten_votes',
                    'name'=>'gotten_votes',
                    'title'=>'Votos obtenidos'
                ])->parameters([
                    'language' => [
                        'url'=>url('vendor/datatables/Spanish.json')
                    ],
                    'order'=>[2,'desc'],
                    'searching'=>false
                    // other configs
                ])->setTableAttribute('id','dtCandidates')
                ->ajax([
                    'url'=>route('api.election.results.candidate'),
                    'data'=>"function (d) {
                                        d.year = $('#year').val();
                                        d.department = $('#departments').val();
                                        d.city = $('#cities').val();
                                        d.leader = $('#leaders').val();
                                        d.candidate = $('#candidate').val();
                                        
                                    }",
                ]);


            $cityChart = Charts::url(route('api.election.results.city'),'pie','highcharts')
            ->data("function(d){}")->container('chartCity');


            $data['tables']=[
                'cities'=>$cityBuilder,
                'leaders'=>$leaderBuilder,
                'candidates'=>$candidatesBuilder,
            ];

            $data['charts']=[
              'cities'=>$cityChart,
            ];

            $data['departments']=Department::orderBy('name')->get();

            return view('admin.dashboard',$data);
        }
        return view('dashboard.index');
    }
    
    
    
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Candidate;
use App\Models\CityElection;
use App\Models\Election;
use App\Models\ElectionCandidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Yajra\DataTables\Facades\DataTables;

class ElectionController extends Controller
{

    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $page = intval($request->input('page'));
        $parent = intval($request->input('linked'));


        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $results = ElectionCandidate::join('candidates','candidates.id','=','candidacies.candidate_id')
            ->where('candidate_id',$parent);

        if ($search_term)
        {
            $results = $results->where('candidates.first_name', 'LIKE', '%'.$search_term.'%');
        }
        $results=$results->selectRaw("candidacies.id, concat(candidates.first_name,' ',candidates.last_name) as name");
        $results = $results->orderBy('name','desc')->paginate(10);
        return $results;
    }

    public function elections(Request $request)
    {
        $search_term = $request->input('q');
        $page = intval($request->input('page'));
        $parent = intval($request->input('linked'));


        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $parent=intval($parent);

        if (!$parent){
            $parent=date('Y');
        }

        $results = Election::whereRaw("year(date) = $parent");

        if ($search_term)
        {
            $results = $results->where('name', 'LIKE', '%'.$search_term.'%');
        }
        $results = $results->orderBy('name','desc')->paginate(10);
        return $results;
    }

    public function resultsCity(Request $request){

        $year = $request->input('year');
        $department = intval($request->input('department'));
        $city = is_array($request->input('city'))?$request->input('city'):[];
        //$leader = intval($request->input('leader'));
        $candidate = intval($request->input('candidate'));

        if(!$year){
            $year=date('Y');
        }


        $query = DB::table('city_election_candidates')->join('candidacies','candidacies.id','=','city_election_candidates.candidacy_id');
        $query=$query->join('cities','cities.id','=','city_election_candidates.city_id');
        $query->whereRaw("year(candidacies.election_date) = $year ");
        $query->selectRaw('cities.name as name,sum(city_election_candidates.votes) as votes');
        $query->groupBy(['cities.id','cities.name']);


        if($department){
            $query->where('cities.department_id',$department);
        }

        if ($city){
            $query->whereIn('cities.id',$city);
        }
        if ($candidate){
            $query->where('candidacies.candidate_id',$candidate);
        }


        if($request->input('chart')){
            $res=$query->get();

            return response()->json([
                'labels'=>$res->map(function ($item, $key) { return $item->name; }),
                'values'=>$res->map(function ($item, $key) { return $item->votes; }),
            ]);
        }
        return DataTables::query($query)
            ->make();
    }

    public function resultsLeader(Request $request){

        $year = $request->input('year');
        $leader = intval($request->input('leader'));

        if(!$year){
            $year=date('Y');
        }


        $query = DB::table('election_users')
            ->join('users','election_users.user_id','=','users.id')
            ->join('candidacies','candidacies.id','=','election_users.candidacy_id');
        $query->leftJoin('users as leader','users.leader_id','=','leader.id');
        $query->whereRaw("year(candidacies.election_date) = $year ");
        $query->selectRaw("coalesce(concat(leader.first_name,' ',leader.last_name),'Sin líder') as fullname,
        coalesce(sum(election_users.zoned),0) as zoned,
        coalesce(sum(election_users.registered),0) as registered,
        coalesce(sum(election_users.controlled),0) as controlled
        ");
        $query->groupBy(['users.leader_id','leader.first_name','leader.last_name']);


        if ($leader){
            $query->where('leader.id',$leader);
            $query->whereNotNull('leader.id');
        }

        if($request->input('chart')){
            $res=$query->get();

            return response()->json([
                'categories'=>$res->map(function ($item, $key) { return $item->fullname; }),
                'series'=>[
                        [
                            'name'=>'Controlados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->controlled); })
                        ],
                        [
                            'name'=>'Registrados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->registered); })
                        ],
                        [
                            'name'=>'Zonificados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->zoned); })
                        ]
                ],
            ]);
        }
        return DataTables::query($query)
            ->make();


    }

    public function resultsCandidate(Request $request){

        $year = $request->input('year');
        $candidate = intval($request->input('candidate'));

        if(!$year){
            $year=date('Y');
        }


        $query = DB::table('candidacies');
        $query=$query->join('candidates','candidates.id','=','candidacies.candidate_id');
        $query->whereRaw("year(candidacies.election_date) = $year ");
        $query->selectRaw("concat(candidates.first_name,' ',candidates.last_name) as name,
        coalesce(sum(candidacies.proyected_votes),0) as proyected_votes,
        coalesce(sum(candidacies.gotten_votes),0) as gotten_votes       
        ");
        $query->groupBy(['candidates.id','name']);

		if ($candidate){
            $query->where('candidacies.candidate_id',$candidate);
        }


        if($request->input('chart')){
            $res=$query->get();

            return response()->json([
                'labels'=>$res->map(function ($item, $key) { return $item->name; }),
                'values'=>$res->map(function ($item, $key) { return $item->proyected_votes; }),
            ]);
        }
        return DataTables::query($query)
            ->make();


    }

}

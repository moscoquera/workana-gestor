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

        $results = ElectionCandidate::join('candidates','candidates.id','=','election_candidates.candidate_id')
            ->where('election_id',$parent);

        if ($search_term)
        {
            $results = $results->where('candidates.name', 'LIKE', '%'.$search_term.'%');
        }
        $results=$results->select(['election_candidates.id','candidates.name']);
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
        $election = intval($request->input('election'));
        $candidate = intval($request->input('candidate'));

        if(!$year){
            $year=date('Y');
        }


        $query = DB::table('city_election_candidates')->join('election_candidates','election_candidates.id','=','city_election_candidates.election_candidate_id');
        $query=$query->join('elections','elections.id','=','election_candidates.election_id');
        $query=$query->join('cities','cities.id','=','city_election_candidates.city_id');
        $query->whereRaw("year(elections.date) = $year ");
        $query->selectRaw('cities.name as name,sum(city_election_candidates.votes) as votes');
        $query->groupBy(['cities.id','cities.name']);


        if($department){
            $query->where('cities.department_id',$department);
        }

        if ($city){
            $query->whereIn('cities.id',$city);
        }

        if ($election){
            $query->where('elections.id',$election);
        }
        if ($candidate){
            $query->where('election_candidates.candidate_id',$candidate);
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
        $election = intval($request->input('election'));

        if(!$year){
            $year=date('Y');
        }


        $query = DB::table('election_users')
            ->join('users','election_users.user_id','=','users.id')
            ->join('elections','elections.id','=','election_users.election_id');
        $query->leftJoin('users as leader','users.leader_id','=','leader.id');
        $query->whereRaw("year(elections.date) = $year ");
        $query->selectRaw("coalesce(concat(leader.first_name,' ',leader.last_name),'Sin líder') as fullname,
        coalesce(sum(election_users.proyected_votes),0) as proyected_votes,
        coalesce(sum(election_users.registered_votes),0) as registered_votes,
        coalesce(sum(election_users.controlled_votes),0) as controlled_votes,
        coalesce(sum(election_users.identified_votes),0) as identified_votes
        ");
        $query->groupBy('users.leader_id');


        if ($election){
            $query->where('elections.id',$election);
        }

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
                            'name'=>'votos proyectados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->proyected_votes); })
                        ],
                        [
                            'name'=>'votos identificados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->identified_votes); })
                        ],
                        [
                            'name'=>'votos registrados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->registered_votes); })
                        ],
                        [
                            'name'=>'votos controlados',
                            'data'=>$res->map(function ($item, $key) { return intval($item->controlled_votes); })
                        ]
                ],
            ]);
        }
        return DataTables::query($query)
            ->make();


    }

    public function resultsCandidate(Request $request){

        $year = $request->input('year');
        $election = intval($request->input('election'));
        $candidate = intval($request->input('candidate'));

        if(!$year){
            $year=date('Y');
        }


        $query = DB::table('election_candidates');
        $query=$query->join('elections','elections.id','=','election_candidates.election_id');
        $query=$query->join('candidates','candidates.id','=','election_candidates.candidate_id');
        $query->whereRaw("year(elections.date) = $year ");
        $query->selectRaw("candidates.name as name,
        case coalesce(sum(election_candidates.elected),0) when 0 then 'No' else 'Sí' end as elected,
        coalesce(sum(election_candidates.proyected_votes),0) as proyected_votes,
        coalesce(sum(election_candidates.gotten_votes),0) as gotten_votes       
        ");
        $query->groupBy(['candidates.id','candidates.name']);


        if ($election){
            $query->where('elections.id',$election);
        }
        if ($candidate){
            $query->where('election_candidates.candidate_id',$candidate);
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

}

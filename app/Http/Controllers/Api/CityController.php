<?php

namespace App\Http\Controllers\Api;

use App\Models\Neighborhood;
use App\Models\Town;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Pagination\Paginator;




class CityController extends Controller
{

    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $page = intval($request->input('page'));
        $parent = intval($request->input('linked'));


        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $results = City::where('department_id',$parent);

        if ($search_term)
        {
            $results = $results->where('name', 'LIKE', '%'.$search_term.'%');
        }
        $results = $results->orderBy('name','desc')->paginate(10);
        return $results;
    }

    public function show($id)
    {
        return City::find($id);
    }


    public function towns(Request $request)
    {
        $search_term = $request->input('q');
        $page = intval($request->input('page'));
        $parent = intval($request->input('linked'));


        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $results = Town::where('city_id',$parent);

        if ($search_term)
        {
            $results = $results->where('name', 'LIKE', '%'.$search_term.'%');
        }
        $results = $results->orderBy('name','desc')->paginate(10);
        return $results;
    }



    public function neighborhoods(Request $request)
    {
        $search_term = $request->input('q');
        $page = intval($request->input('page'));
        $parent = intval($request->input('linked'));


        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $results = Neighborhood::where('city_id',$parent);

        if ($search_term)
        {
            $results = $results->where('name', 'LIKE', '%'.$search_term.'%');
        }
        $results = $results->orderBy('name','desc')->paginate(10);
        return $results;
    }

}

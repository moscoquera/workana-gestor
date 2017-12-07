<?php

namespace App\Http\Controllers\Api;

use App\Models\PublicUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class UsersController extends Controller
{


    public function users(Request $request)
    {
        $search_term = $request->input('q');
        $page = intval($request->input('page'));
        $parent = intval($request->input('linked'));


        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $results = PublicUser::selectRaw("users.*, concat(first_name,' ',last_name) as fullname");

        if ($search_term)
        {
            $results = $results->whereRaw("concat(first_name,' ',last_name) like '%".$search_term."%'");
        }
        $results = $results->orderBy('fullname','desc')->paginate(10);
        return $results;
    }



}

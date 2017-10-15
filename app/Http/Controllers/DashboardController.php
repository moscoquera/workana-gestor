<?php

namespace App\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends CrudController
{
    
    public function __construct() {
    
    //    $this->middleware('auth');
    }
    
    function index(){


        dd(get_class(Auth::user()));
        //return view('dashboard.index');
    }
    
    
    
}

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

        if (Auth::user()->isAdmin()){
            return view('admin.dashboard');
        }
        return view('dashboard.index');
    }
    
    
    
}

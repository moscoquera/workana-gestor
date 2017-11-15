<?php

namespace App\Http\Controllers;

use App\Models\Contract;
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
            $data=[];
            $data['contracts']=[
                'all'=>Contract::count(),
                'active'=>Contract::active()->count(),
                'ended'=>Contract::ended()->count(),
                'nostarted'=>Contract::noStarted()->count(),
            ];
            return view('admin.dashboard',$data);
        }
        return view('dashboard.index');
    }
    
    
    
}

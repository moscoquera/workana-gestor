<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function __construct() {
    
        $this->middleware('auth');
    }
    
    function Home(){
        return view('dashboard.index');
    }
    
    
    
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;



class AdminsOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=Auth::user();
        //dd($request->user());
        if (!Auth::check() || Auth::user()->rol->id!=1){
            return redirect('');
        }
        return $next($request);
    }
}

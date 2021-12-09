<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle(Request $request, Closure $next)
    {
        // return $next($request);
        if (Session::get('login')==false) {
            return redirect('login');
        } 
        // else {
        //     return redirect('dashboard');
        // }
        return $next($request);
    }


    
}

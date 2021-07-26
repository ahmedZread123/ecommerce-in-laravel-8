<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

// use Request ;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo( $request)
    {
    //    dd($request->route())  ; 

        if (!$request->expectsJson()) {
            
            if (FacadesRequest::is('admin') ||FacadesRequest::is('admin/*')  ){

             return route('admin.login');
            }elseif(FacadesRequest::is('vendor') ||FacadesRequest::is('vendor/*')){
                return route('getlogin');
            }
            else
            return route('login');
        
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Session;

class Localization
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
        if(Auth()->user()){
            Session::put('locale', Auth()->user()->language);
            App::setLocale(Auth()->user()->language);
        }
        else
            App::setLocale('en');

        return $next($request);
    }
}

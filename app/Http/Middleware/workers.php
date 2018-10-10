<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class workers
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
        if(Auth::check()){
            //da li je admin
            if(Auth::user()->isAdministrator() || Auth::user()->isModerator() || Auth::user()->isJournalist()){
                return $next($request);
            }
        }
        return redirect()->back();
    }
}

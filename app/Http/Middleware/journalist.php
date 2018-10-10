<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class journalist
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

            if(Auth::user()->isJournalist()){
                return $next($request);
            }
        }
        return redirect()->back();
    }
}

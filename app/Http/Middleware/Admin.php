<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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

        if(auth('admin')->check()){
            return $next($request);

        }

        return response()->json(['loggedIn'=>false,'message'=>'Not authorized to access this api'],401);
    }
}

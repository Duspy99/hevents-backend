<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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

        if (auth('api')->user())
        {
            if(auth('api')->user()->role != '99')
            {
                return response()->json(['error' => 'Forbidden.'], 403);
            }
            return $next($request);
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}

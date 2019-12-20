<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class ApiAuthenticate
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
        $permission = Route::currentRouteName();
        dd($permission);
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuthenticate
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
        if(! $request->has('auth') && request()->getRequestUri() !== '/' && request()->getRequestUri() !== '/posts') {
            return redirect('/');
        }

        return $next($request);
    }
}

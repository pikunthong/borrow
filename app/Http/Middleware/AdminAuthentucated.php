<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthentucated
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
        if(!\Auth::guard('admin')->user()){
            return redirect('/back-office/login');
        }
        return $next($request);
    }
}

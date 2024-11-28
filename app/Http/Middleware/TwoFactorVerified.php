<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactorVerified
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
        if(\Auth::check() && !is_null(\Auth::user()->two_factor_verified_at) ){ 
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class OtpVerified
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check() && (!is_null(\Auth::user()->otp) && !is_null(\Auth::user()->otp_verified_at)) ){ 
            return $next($request);
        }else{
            
            return $request->expectsJson()
                    ? $this->sendError('Error.',"Otp is not verified.")
                    : redirect()->guest( route('login'));
        }
    }
}

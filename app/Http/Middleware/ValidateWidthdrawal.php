<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ValidateWidthdrawal
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
        $auth = Auth::user();
        $otp_email = session('check_success');
        if(!$otp_email){
            return redirect()->route('valid.email.withdrawal');
        }
        $email_check = session('email_check');
        if($email_check){
            if($email_check != $auth->email){
                return redirect()->route('valid.email.withdrawal');
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckImage
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
        if($auth->check_active != 1){
            return redirect()->route('account.detail')->with('warning','Bạn cần cung cấp đầy đủ ảnh, giấy tờ cần thiết để xác thực tài khoản');
        }
        return $next($request);
    }
}

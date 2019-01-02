<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Verification
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
//        $request->session()->push('username', 'default');
//        $uin = $request->cookie('uin');
//        $sUin = session('uin');

//        var_dump($uin, 'adsf', $sUin);
//        dd(cookie('alanblog_session'),'session',session('uin'));

        return $next($request);
    }
}

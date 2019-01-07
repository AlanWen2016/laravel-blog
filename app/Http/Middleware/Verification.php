<?php

namespace App\Http\Middleware;

use Closure;
use Mockery\Expectation;

class Verification
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
        $cookie = $request->cookie('alan_sid');
        $sessionId = $request->session()->get('sid');
        if($cookie && $cookie === $sessionId){
            return $next($request);
        }
        return response()->json(['error' => 1, 'ำรปงฮดตวยผ~']);
    }
}

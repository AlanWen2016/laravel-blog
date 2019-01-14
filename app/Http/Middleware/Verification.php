<?php

namespace App\Http\Middleware;

use App\Http\Protocol\LoginUser;
use App\Services\User\UserService;
use Closure;


class Verification
{
    protected $loginUser;
    protected $userService;


    public function __construct(UserService $userService, LoginUser $loginUser)
    {
        $this->userService = $userService;
        $this->loginUser = $loginUser;
    }



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
            $loginName = $request->session()->get('loginName');
            $user = $this->userService->getUser($loginName);
            if(empty($user)){
                return response()->json(['error' => 1, '登陆失败~']);
            }
            $this->loginUser->setLoginName($loginName);
            $this->loginUser->setNickname($user->nick_name);
            return $next($request);
        }
        return response()->json(['error' => 1, '用户未登录~']);
    }
}

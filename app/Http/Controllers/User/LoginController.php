<?php

namespace App\Http\Controllers\User;

use App\Services\User\LoginService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class LoginController extends Controller
{
    //

    public function login(Request $request, LoginService $loginService, UserService $userService)
    {

            $name = $request->input('name');
            $password = $request->input('password');
            if (empty($name) || empty($password)) {
                throw new Exception('参数错误，请重新登录');
            }

//            Auth::attempt()
            // 查数据库
            $userInfo = $userService->getUserInfo($name, $password);
            $sid = sha1('alan_' . md5($name . time() . rand(1, 999)) );
        $sids = cookie('alan_sid' . (env('APP_ENV') == 'local' ? '' : '_' . env('APP_ENV')), $sid,
            time() + 604800, '/', 'alanwen.online');
            $cookie = cookie('name', 'value', 12, '/');
        session(['sid' => $sid]);
        return response('Hello World')->cookie($cookie)->cookie($sids);
//            return response('Hello World')->withcookie(
//                'name', 'value', 123,'/', 'alanwen.online'
//            );
            return response()->json($userInfo);



    }
}

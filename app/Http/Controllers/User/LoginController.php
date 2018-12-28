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
            $loginService->makeSession($name);
            $cookie = cookie('name', 'value', 12, '/');

        return response('Hello World')->cookie($cookie);
//            return response('Hello World')->withcookie(
//                'name', 'value', 123,'/', 'alanwen.online'
//            );
            return response()->json($userInfo);



    }
}

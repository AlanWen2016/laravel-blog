<?php

namespace App\Http\Controllers\User;

use App\Services\User\LoginService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Mockery\Exception;

class LoginController extends Controller
{
    //
    public function __construct()
    {

    }

    public function login(Request $request, LoginService $loginService, UserService $userService)
    {

        $name = $request->input('name');
        $password = $request->input('password');
        if (empty($name) || empty($password)) {
            throw new Exception('参数错误，请重新登录');
        }
//            Auth::attempt()
//             查数据库
        $userInfo = $userService->getUserInfo($name, $password);
        if(empty($userInfo)){
            return $this->json_failure('登录失败~');
        }

        $domain = $_SERVER['HTTP_HOST'];
        $uid = sha1('alan_' . md5($name . time() . rand(1, 999)) );
        setcookie('userInfo', $uid, time() + 604800, '/', $domain);
        session(['uin'=> $uid]);
//            $foreverCookie = Cookie::forever('forever1234', 'Success');
        return response()->json($userInfo);

    }
}

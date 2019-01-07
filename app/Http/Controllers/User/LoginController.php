<?php

namespace App\Http\Controllers\User;

use App\Services\User\LoginService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class LoginController extends Controller
{

    /**
     * 用户登陆
     * @param Request $request
     * @param UserService $userService
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request, UserService $userService)
    {

        $name = $request->input('name');
        $password = $request->input('password');
        if (empty($name) || empty($password)) {
            throw new Exception('参数错误，请重新登录');
        }
        // 查数据库
        $userInfo = $userService->getUserInfo($name, $password);
        if(empty($userInfo)){
            return $this->json_failure('用户不存在~');
        }
        $sid = sha1('alan_' . md5($name . time() . rand(1, 999)) );
        $cookie = cookie('alan_sid', $sid, 60*24*7, '/', 'alanwen.online');
        session(['sid' => $sid]);
        return response()->json($userInfo)->cookie($cookie);
    }


    /**
     * 用户注册
     * @param Request $request
     * @param UserService $userService
     * @param LoginService $loginService
     * @return mixed
     */
    public function register(Request $request, UserService $userService, LoginService $loginService)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            throw new Exception($validator->messages()->first());
        }
        return $ret = $loginService->createUser($request->only(['name', 'email', 'password']));

    }





}

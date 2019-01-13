<?php

namespace App\Http\Controllers\User;

use App\Services\User\LoginService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
     * 拉取登录qq Url
     * @param LoginService $loginService
     * @param Request $request
     * @return array
     */
    public function qqLoginUrl(LoginService $loginService, Request $request)
    {
        $refer = $request->input('refer');
        return [
            'url' => $loginService->qqLoginUrl($refer),
        ];
    }


    /**
     * QQ登录回调
     * @param Request $request
     * @param LoginService $loginService
     * @param UserService $userService
     * @return $this
     */
    public function qqLoginCallback(Request $request,LoginService $loginService, UserService $userService)
    {
        try {
            $code = $request->input('code');
            $state = $request->input('state');
            if (empty($code) || empty($state)) {
                throw new Exception('回调参数错误，请重新登录');
            }
            $data  = $request->session()->get('state');;
            if (empty($data)) {
                throw new Exception('回调参数错误，请重新登录');
            }
            $result = $loginService->qqOpenIdAndToken($code);
            $userInfo = $userService->createUserOfQQOpenid($result['openid'], $result['access_token']);
            $loginName = $userInfo->login_name;
            $sid = sha1('alan_' . md5($loginName . time() . rand(1, 999)) );
            $cookie = cookie('alan_sid', $sid, 60*24*7, '/', 'alanwen.online');
            session(['sid' => $sid]);
            return response()->view('login.login')->withCookie($cookie);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * 登出
     * @return $this
     */
    public function logout()
    {
        $cookie = cookie('alan_sid', null, 0, '/', 'alanwen.online');
        session(['sid' => null]);
        return response()->json(['code'=> 0, 'msg'=> 'logout successful'])->withCookie($cookie);
    }



}

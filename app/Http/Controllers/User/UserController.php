<?php

namespace App\Http\Controllers\User;

use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index(UserService $userService, Request $request)
    {
        $cookie = $request->cookie('alan_sid');
        $sessionId = $request->session()->get('sid');
        if($cookie && $cookie === $sessionId){
//            return '登陆成功';
        }
        $users =  $userService->getUser();
        return response()->json($users);
    }
}

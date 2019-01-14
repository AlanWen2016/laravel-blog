<?php

namespace App\Http\Controllers\User;

use App\Http\Protocol\LoginUser;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     * @param Request $request
     * @param LoginUser $loginUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserService $userService, Request $request, LoginUser $loginUser)
    {
        // LoginUser为什么没有值？？？

        $user = $userService->getUser(session('loginName'));
        return response()->json($user);
    }

}

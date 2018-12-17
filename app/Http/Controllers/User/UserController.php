<?php

namespace App\Http\Controllers\User;

use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index(UserService $userService)
    {
        $users =  $userService->getUser();
        return response()->json($users);
    }
}

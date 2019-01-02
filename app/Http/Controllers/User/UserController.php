<?php

namespace App\Http\Controllers\User;

use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    //
    public function index(Request $request, UserService $userService)
    {
        $uin = $request->cookie('userInfo');


        dd($uin);
        $users =  $userService->getUser();
        $foreverCookie = Cookie::forever('forever', 'Success');
        $tempCookie = Cookie::make('temporary', 'Victory', 5);

        return response()->json([1234])->cookie($foreverCookie);

    }

}

<?php

namespace App\Services\User;


use App\Models\User;
use App\Services\CommonService;
use Illuminate\Support\Facades\Hash;

class UserService extends CommonService
{


    public function __construct()
    {

    }

    public function getUser()
    {
        return $users = User::find(1);

    }


    /**
     * 返回用户信息
     * @param $name
     * @param $password
     * @return array
     */
    public function getUserInfo($name, $password)
    {
        $userInfo = User::where('name', '=', $name)->first();
        if(empty($userInfo)){
            return [];
        }
        if(Hash::check($password, $userInfo->password)){
            return $userInfo;
        }
    }

}
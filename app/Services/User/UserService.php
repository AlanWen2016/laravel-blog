<?php

namespace App\Services\User;


use App\Models\User;
use App\Services\CommonService;

class UserService extends CommonService
{


    public function __construct()
    {

    }

    public function getUser()
    {
        return $users = User::find(8);

    }

}
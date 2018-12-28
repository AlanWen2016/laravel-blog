<?php

namespace App\Services\User;


use App\Models\User;
use App\Services\CommonService;

class LoginService extends CommonService
{


    public function __construct()
    {

    }


    public function makeSession($loginName)
    {
        $sid = sha1('alan_' . md5($loginName . time() . rand(1, 999)) );
        setcookie('alan_sid' . (env('APP_ENV') == 'local' ? '' : '_' . env('APP_ENV')), $sid,
            time() + 604800, '/', '.alanwen.online', false, true);
    }





}
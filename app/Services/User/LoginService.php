<?php

namespace App\Services\User;


use App\Models\User;
use App\Services\CommonService;

class LoginService extends CommonService
{


    public function __construct()
    {
    }


    /**
     * qq互联登录地址
     * @param $refer
     * @return string
     */
    public function qqLoginUrl( $refer)
    {
        $url = env('qq_login_url') . '?response_type=code&client_id=' . env('QQ_KEY') . '&redirect_uri=';
        $redirectUrl = env('QQ_REDIRECT_URI');
        if (isset($_SERVER['HTTP_X_CLIENT_PROTO']) && $_SERVER['HTTP_X_CLIENT_PROTO'] == 'https') {
            $redirectUrl = str_replace('http', 'https', $redirectUrl);
        }
        $url .= $redirectUrl;
        return $url . '?state=' . $this->loginState($url, $refer);
    }


    /**
     * 登陆校验码
     * @return string
     */
    protected function loginState()
    {
        $state = 'test';
        session(['state' => $state]);
        return $state;
    }


    /**
     * 回调获取QQ互联登录用户的openid和accesstoken
     * @param $code
     * @return array
     */
    public function qqOpenIdAndToken($code)
    {
        //code换取access_token
        return [
            'openid'        => '',
            'access_token'  => '',
            'expires_in'    => ''
        ];
    }







}
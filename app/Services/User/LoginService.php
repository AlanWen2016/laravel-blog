<?php

namespace App\Services\User;


use App\Models\User;
use App\Services\CommonService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

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
        $url = env('qq_login_url') . '?response_type=code&client_id=' . env('qq_login_appid') . '&redirect_uri=';
        $redirectUrl = env('qq_login_callback');
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
        $client = new Client();
        $token = [];
        // step1: code换取access_token
        try {
            $params = [
                'grant_type' => 'authorization_code',
                'client_id' => env('qq_login_appid'),
                'client_secret' => env('qq_login_secret'),
                'code' => $code,
                'redirect_uri' => env('qq_login_callback')
            ];

            // 发送get请求
            $response = $client->request('GET', env('qq_login_token_url'), [
                'query' =>$params
            ]);

            $accessTokenString = $response->getBody()->getContents();
            parse_str($accessTokenString, $token);

//            Log::info('access_token'.$accessTokenString);
            if (!isset($token['access_token']) || empty($token['access_token'])) {
                Log::error('QQ登录查询access_token返回：' . $accessTokenString);
            }
        } catch (\Exception $e) {
            Log::error('QQ登录查询access_token失败：' . $e->getMessage());

        }


        //获取用户openid
        try {
            $openidParams = [
                'access_token' => $token['access_token']
            ];
            // 发送get请求
            $openidResult = $client->request('GET', env('qq_login_openid_url'), [
                'query' =>$openidParams
            ]);
            $openidResultString = $openidResult->getBody()->getContents();

            Log::info($openidResultString.'$openidParams');

            $start = strpos($openidResultString, '{');
            $end = strpos($openidResultString, '}');

            $openidResult = substr($openidResultString, $start, $end - $start + 1);
            $openid = json_decode($openidResult, true);



            if (!isset($openid['openid']) || empty($openid['openid'])) {
                Log::error('QQ登录查询openid返回：' . $openidResult);

            }

            //code换取access_token
            return [
                'openid'        => $openid['openid'],
                'access_token'  => $token['access_token'],
                'expires_in'    => $token['expires_in']
            ];

        } catch (\Exception $e) {
            Log::error('QQ登录查询openid失败：' . $e->getMessage());

        }
    }










}
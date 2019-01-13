<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\LoginService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    //


    public function getGuzzle(Request $request)
    {

        $code = '71F085019B3E6CF054A37EBE3E37A644';
        $params = [
            'grant_type' => "authorization_code",
            'client_id' => env('qq_login_appid'),
            'client_secret' => env('qq_login_secret'),
            'code' => $code,
            'redirect_uri' => env('qq_login_callback')
        ];


        // 发送get请求
        $client = new Client();
        $response = $client->request('GET', env('qq_login_token_url'), [
            'query' =>$params
        ]);

        dd($response->getBody()->getContents());
        $callback = json_decode($response->getBody()->getContents());

        return $this->json_out('200', '测试图灵机器人返回结果', $callback);
    }


    public function test(LoginService $loginService, UserService $userService)
    {

        $openid = '3C5D43E3658CFE6973A7BA6A32E2DAA0';
        $accessToken = '2FE8C508304D3CAB8EA72E5ACF077D20';
        $ret = $userService->createUserOfQQOpenid($openid, $accessToken);

        dd($ret);


        $str = "access_token=2FE8C508304D3CAB8EA72E5ACF077D20&expires_in=7776000&refresh_token=B160A779F633B32891E68F5B2856493E";
        $openIdStr = '{"client_id":"101533017","openid":"3C5D43E3658CFE6973A7BA6A32E2DAA0"}';

        $openid = json_decode($openIdStr, true);

        dd($openid);
        $token = [];
        parse_str($str, $token);
        dd($token);
        $code = '923ED9E2162EB415CE6C13D91D578F31';
        $ret = $loginService->qqOpenIdAndToken($code);
        dd($ret);

    }



}

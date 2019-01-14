<?php

namespace App\Services\User;


use App\Models\User;
use App\Services\CommonService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class UserService extends CommonService
{


    public function __construct()
    {

    }

    public function getUser($loginName)
    {
        return $users = User::where('login_name','=', $loginName)->first();
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


    /**
     * 创建用户并返回用户信息
     * @param $openId
     * @param $accessToken
     * @return string
     */
    public function createUserOfQQOpenid($openId, $accessToken)
    {
        $loginName = '';
        $qqUserInfo = $this->getQQInfo($openId, $accessToken);
        if(empty($qqUserInfo)){
            return $loginName;
        }
        $userInfo = User::where('qq_openid', '=', $openId)->first();
        $userData = [
            'qq_openid' => $openId,
            'login_name' => $openId,
            'avatar' => $qqUserInfo['figureurl_qq_2'],
            'nick_name' => $qqUserInfo['nickname'],
        ];
        if(!empty($userInfo)){
            $userInfo->avatar = $qqUserInfo['figureurl_qq_2'];
            $userInfo->nick_name = $qqUserInfo['nickname'];
            $userInfo->save();
            return $userInfo;
        }
        return $user = User::create($userData);
    }




    /**
     * QQ互联拉取用户信息
     * @param $openId
     * @param $accessToken
     * @return mixed|string
     */
    public function getQQInfo($openId, $accessToken)
    {
        $client = new Client();
        try {
            $params = [
                'access_token'          => $accessToken,
                'oauth_consumer_key'    => env('qq_login_appid'),
                'openid'                => $openId
            ];
            // 发送get请求
            $response = $client->request('GET', env('qq_user_info'), [
                'query' =>$params
            ]);
            $result = $response->getBody()->getContents();

            Log::info('userInfo: '.$result);
            $result = json_decode($result, true);

            if (!isset($result['ret']) || $result['ret'] != 0) {
                Log::error('用户QQ信息获取失败：' . json_encode($result));
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('获取QQ信息失败：' . $e->getMessage());
        }
    }


}
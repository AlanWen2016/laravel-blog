<?php


namespace App\Http\Protocol;

/**
 * 当前登录用户
 * Class LoginUser
 * @package App\Http\Protocal
 */
class LoginUser
{

    /**
     * @var string tgl用户唯一标识
     */
    protected $loginName;

    /**
     * @var string 用户qq
     */
    protected $qq;

    /**
     * @var string 用户昵称
     */
    protected $nickname;



    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * @param string $loginName
     */
    public function setLoginName($loginName)
    {
        $this->loginName = $loginName;
    }

    /**
     * @return string
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * @param string $qq
     */
    public function setQq($qq)
    {
        $this->qq = $qq;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }



}
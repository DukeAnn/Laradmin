<?php
/**
 * Created by PhpStorm.
 * User: 雷雷
 * Date: 2017/1/4
 * Time: 21:31
 */

namespace App\Services\Wechat;

use App\Repositories\Eloquent\WechatUserRepositoryEloquent;

class UserService
{
    protected $model_wechat_user;

    //服务端应用实例
    protected $wechat;

    //服务器配对用户OpenID
    public $pair_openid;

    public function __construct(WechatUserRepositoryEloquent $wechat_user)
    {
        $this->model_wechat_user =  $wechat_user;
    }

    /**
     * 服务端应用实例
     * @param int $openId
     * */
    public function setWechat($openId)
    {
        $this->wechat = app('wechat');
        $user = $this->wechat->user->get($openId);
        return $user;
    }

    /**
     * 保存微信用户
     * @param object $user 微信用户对象
     * @return bool
     * */
    public function saveUser($user)
    {
        //判断关注
        if ($user->subscribe) {
            //查询是否已经存储
            $local_user = $this->model_wechat_user->getUserByOpenid($user->openid);
            if (count($local_user) == 0) {
                $result = $this->model_wechat_user->saveUser($user);
                return $result;
            }
            return true;
        }
        return false;
    }

    /**
     * 用户配对，返回配对用户OpenID
     * @param string $openid
     * */
    public function UserPairByOpenid($openid)
    {
        $local_user = $this->model_wechat_user->getUserObject(['openid' => $openid]);
        //检查是否配对
        if ($local_user->pair_id == 0) {
            //进行配对
            $local_user_pair = $this->model_wechat_user->getPairUser($local_user);
            if ($local_user_pair) {
                //如果配对成功获取openid
                $this->pair_openid = $local_user_pair->openid;
            } else {
                $this->pair_openid = false;
            }
        } else {
            //已配对直接获取
            $local_user_pair = $this->model_wechat_user->getUserObject(['id' => $local_user->pair_id]);
            $this->pair_openid = $local_user_pair->openid;
        }
    }
}

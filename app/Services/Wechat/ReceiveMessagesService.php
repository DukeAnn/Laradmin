<?php
/**
 * 接收微信消息处理类
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2017/1/3 0003
 * Time: 9:44
 * @author ADKi
 */

namespace App\Services\Wechat;

use App\Repositories\Eloquent\WechatMessageRepositoryEloquent;
use App\Services\Wechat\UserService;

class ReceiveMessagesService
{
    /**
     * @var object $message 微信消息实例
     * */

    protected $model_wechat_message;

    protected $service_wechat_user;

    //保存存储状态
    protected $return;

    //返回消息
    public $return_message;

    public function __construct(WechatMessageRepositoryEloquent $messageRepositoryEloquent, UserService $wechat_user)
    {
        $this->model_wechat_message = $messageRepositoryEloquent;

        $this->service_wechat_user =  $wechat_user;
    }

    /**
     * 保存消息
     * @param object $message 微信消息
     * */
    public function saveMessages($message)
    {
        $result = $this->model_wechat_message->saveMessages($message);
        if ($result) {
            //获取配对用户openid
            $this->service_wechat_user->UserPairByOpenid($message->FromUserName);
            //已配对的发送通知
            if ($this->service_wechat_user->pair_openid) {
                $userId = $this->service_wechat_user->pair_openid;
                $templateId = 'vHd_CfcOpjYswtXwUgOz93o0E0PRIrzZUBMZxB1f9Gg';
                $url = '';
                $color = '#FF0000';
                $data = array(
                    "message"   => $message->Content,
                );

                //保存消息成功进行推送
                $wechat = app('wechat');
                $notice = $wechat->notice;
                $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
            }
            $this->return_message = '您的信已送达，请耐心等待回信吧！';
        } else {
            $this->return_message = '不好意思您的信丢了';
        }
    }

    /**
     * 拉取配对用户消息，如果未配对$openid为空
     * @param string $openid
     * */
    public function getPairMessage($openid)
    {
        if ($openid) {
            $result = $this->model_wechat_message->getPairMessage(['openid' => $openid]);
            if (is_object($result)) {
                $this->return_message = $result;
            } else {
                $this->return_message = '无未读消息';
            }
        } else {
            $this->return_message = '阿狸正在查找您的笔友~';
        }
    }
}

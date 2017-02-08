<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Services\Wechat\ReceiveMessagesService;
use App\Services\Wechat\UserService;

class WechatController extends Controller
{
    protected $messagesService;

    protected $userService;

    public function __construct(ReceiveMessagesService $messagesService, UserService $userService)
    {
        $this->messagesService = $messagesService;
        $this->userService = $userService;
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        //实例化微信服务
        $wechat = app('wechat');
        //接收微信数据 $message 为微信消息实例
        $wechat->server->setMessageHandler(function($message){
            //微信用户实例化
            $wechat_user = $this->userService->setWechat($message->FromUserName);
            //保存微信用户
            $this->userService->saveUser($wechat_user);
            //用户配对
            $this->userService->UserPairByOpenid($wechat_user->openid);

            //微信消息处理类,保存消息
            if ($message->Content == '收信') {
                //获取配对消息
                $this->messagesService->getPairMessage($this->userService->pair_openid);
            } else {
                //保存消息
                $this->messagesService->saveMessages($message);
            }

            if (is_object($this->messagesService->return_message)) {
                switch ($this->messagesService->return_message->msg_type) {
                    case 'event':
                        # 事件消息...
                        break;
                    case 'text':
                        $return_message = $this->messagesService->return_message->content;
                        break;
                    case 'image':
                        # 图片消息...
                        break;
                    case 'voice':
                        # 语音消息...
                        break;
                    case 'video':
                        # 视频消息...
                        break;
                    case 'location':
                        # 坐标消息...
                        break;
                    case 'link':
                        # 链接消息...
                        break;
                    // ... 其它消息
                    default:
                        $return_message = $message->FromUserName."：欢迎关注 DukeAnn！";
                        break;
                }
            } else {
                $return_message = $this->messagesService->return_message;
            }
            return $return_message;
        });

        return $wechat->server->serve();
    }
}

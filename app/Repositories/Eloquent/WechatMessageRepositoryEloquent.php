<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\WechatMessageRepository;
use App\Models\WechatMessage;

/**
 * Class WechatMessageRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class WechatMessageRepositoryEloquent extends BaseRepository implements WechatMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatMessage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 保存微信用户发送的消息
     * @param object $message
     * @return bool
     * */
    public function saveMessages($message)
    {
        $this->model->openid = $message->FromUserName;
        $this->model->create_time = $message->CreateTime;
        $this->model->msg_id = $message->MsgId;
        $this->model->msg_type = $message->MsgType;
        $this->model->content = $message->Content;
        $this->model->media_id = $message->MediaId;
        $this->model->pic_url = $message->PicUrl;
        $this->model->format = $message->Format;
        $this->model->thumb_media_id = $message->ThumbMediaId;
        $this->model->location_x = $message->Location_X;
        $this->model->location_y = $message->Location_Y;
        $this->model->title = $message->Title;
        $this->model->description = $message->Description;
        $this->model->url = $message->Url;
        if ($this->model->save()) {
            return true;
        }
        return false;
    }

    /**
     * 获取配对微信消息
     * */
    public function getPairMessage($contidion)
    {
        $contidion['read_state'] = 0;
        $message = $this->model->where($contidion)->first();
        if (!empty($message)) {
            //标志已读
            $message->read_state = 1;
            $message->save();
            return $message;
        }
        return false;
    }
}

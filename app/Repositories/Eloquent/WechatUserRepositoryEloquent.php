<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\WechatUserRepository;
use App\Models\WechatUser;

/**
 * Class WechatUserRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class WechatUserRepositoryEloquent extends BaseRepository implements WechatUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WechatUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 保存微信用户
     * @param object $user 微信用户信息
     * @return bool
     * */
    public function saveUser($user)
    {
        $this->model->openid = $user->openid;
        $this->model->nickname = $user->nickname;
        $this->model->sex = $user->sex;
        $this->model->city = $user->city;
        $this->model->country = $user->country;
        $this->model->province = $user->province;
        $this->model->language = $user->language;
        $this->model->headimgurl = $user->headimgurl;
        $this->model->subscribe_time = $user->subscribe_time;
        $this->model->unionid = $user->unionid;
        $this->model->remark = $user->remark;
        $this->model->groupid = $user->groupid;
        $this->model->tagid_list = serialize($user->tagid_list);
        if ($this->model->save()) {
            return true;
        }
        return false;
    }

    /**
     * 根据OpenID查询
     * @param string $Openid
     * @return array
     * */
    public function getUserByOpenid($Openid)
    {
        $user_info = $this->findWhere(['openid' => $Openid]);
        return $user_info;
    }

    /**
     * 查询user对象
     * @param array $condition
     * @return object
     * */
    public function getUserObject(array $condition)
    {
        $user_info = $this->model->where($condition)->first();
        return $user_info;
    }

    /**
     * 获取一名异性随机用户
     * @param WechatUser $wechatUser
     * @return WechatUser
     * */
    public function getPairUser(WechatUser $wechatUser)
    {
        if ($wechatUser->sex == 1) {
            $sex = 2;
        } elseif ($wechatUser->sex == 2) {
            $sex = 1;
        } else {
            $sex = 0;
        }
        //根据条件获取配对用户
        $user_pair = $this->getUserObject(['pair_id' => 0, 'sex' => $sex]);
        if (!empty($user_pair)) {
            $pair_time = time();
            $user_pair->pair_time = $pair_time;
            $user_pair->pair_id = $wechatUser->id;
            $user_pair->save();

            $wechatUser->pair_time =  $pair_time;
            $wechatUser->pair_id =  $user_pair->id;
            $wechatUser->save();

            return $user_pair;
        }
        return false;
    }
}

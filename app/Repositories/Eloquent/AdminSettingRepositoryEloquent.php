<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\AdminSettingRepository;
use App\Models\AdminSetting;

/**
 * Class AdminSettingRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class AdminSettingRepositoryEloquent extends BaseRepository implements AdminSettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminSetting::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /*
     * 获取全部设置选项
     * */
    public function getAll()
    {
        return $this->all();
    }

    /**
     * 保存选项设置
     * @param $id int ID
     * @param $request \Illuminate\Http\Request
     * @return bool
     * */
    public function saveSet($id, $request)
    {
        $set = $this->model->find($id);
        $set->value = $request->value;
        return $set->save();
    }
    
    /**
     * 根据code获取值
     * @param $code string 键值
     * */
    public static function getValue($code)
    {
        $result = AdminSetting::where(['code' => $code])->first();
        return $result->value;
    }
}

<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ImageRepository;
use App\Models\Image;
use Storage;

/**
 * Class ImageRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ImageRepositoryEloquent extends BaseRepository implements ImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Image::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 保存
     * @param $file_arr array 文件信息
     * @param $user object 用户对象
     * @return bool 存储的ID
     * */
    public function saveImage($file_arr, $user)
    {
        $this->model->user_id = $user->id;
        $this->model->user_name = $user->name;
        $this->model->path = $file_arr['original'];
        $this->model->name = $file_arr['filename'];
        $this->model->filename = $file_arr['filename'];
        $this->model->extension = $file_arr['extension'];
        $this->model->year_month = $file_arr['year_month'];
        $this->model->size = Storage::size($file_arr['original']);
        if ($this->model->save()) {
            return $this->model->id;
        }
        return false;
    }

    /**
     * 获取文件列表
     * @param $limit int 分页长度
     * @param $condition array 查询条件
     * @param $order string 排序字段
     * @param $sort string 排序方式
     * @return object
     * */
    public function getList($limit = 10, $condition = array(), $order = 'created_at', $sort = 'desc')
    {
        return $this->model->where($condition)->orderBy($order, $sort)->paginate($limit);
    }

    /**
     * 获取年份月份
     * */
    public function getYearMonth()
    {
        $year_months = $this->model->groupBy('year_month')->orderBy('year_month', 'desc')->get(['year_month'])->toArray();
        return $year_months;
    }

    /**
     * 获取图片详细信息
     * @param $id int 图片ID
     * @return object
     * */
    public function getInfo($id)
    {
        return $this->find($id);
    }

    /*
     * 删除图片
     * */
    public function destroy($id)
    {
        return $this->delete($id);
    }

    /*
     * 编辑文件
     * */
    public function edit($id, $request)
    {
        $image = $this->model->find($id);
        $image->filename = $request->filename;
        return $image->save();
    }

}

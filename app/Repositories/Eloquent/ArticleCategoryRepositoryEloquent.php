<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ArticleCategoryRepository;
use App\Models\ArticleCategory;
use App\Repositories\Validators\ArticleCategoryValidator;

/**
 * Class ArticleCategoryRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ArticleCategoryRepositoryEloquent extends BaseRepository implements ArticleCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ArticleCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 获取全部分类
     * @param int $parent_id 父类ID
     * @return array
     * */
    public function getAllCate($parent_id = 0)
    {
        $cates = $this->model->where('parent_id' , $parent_id)->orderBy('order' ,'asc')->get();
        $all_cate = array();
        if (!empty($cates)) {
            foreach ($cates as $key => $cate) {
                $all_cate[$cate->id] = $cate;
                //查询子菜单
                $cate_child = $this->getAllCate($cate->id);
                if (!empty($cate_child)) {
                    //子菜单不为空放在 child 数组中
                    $all_cate[$cate->id]['child'] = $cate_child;
                }
            }
        }
        return $all_cate;
    }
    
    /**
     * 保存新增分类
     * @param $data object 保存信息
     * @return array
     * */
    public function saveCate($data)
    {
        $this->model->name = $data->name;
        $this->model->describe = $data->describe;
        $this->model->display_name = $data->display_name;
        $this->model->parent_id = $data->parent_id;
        if ($this->model->save()) {
            $result = true;
        } else {
            $result = false;
        }
        return [
            'status' => $result,
            'message' => $result ? '分类添加成功':'分类添加失败',
        ];
    }

    /**
     * 更新分类
     * @param int $id
     * @param object $request
     * @return array
     * */
    public function updateCate($id, $request)
    {
        $cate_info = $this->find($id);
        $cate_info->name = $request->name;
        $cate_info->describe = $request->describe;
        $cate_info->display_name = $request->display_name;
        if ($cate_info->save()) {
            $result = true;
        } else {
            $result = false;
        }
        return [
            'status' => $result,
            'message' => $result ? '分类更新成功':'分类更新失败',
        ];
    }

    /**
     * 保存分类排序
     * @param object $cates
     * @param int $parent_id
     * @return bool
     * */
    public function saveCateOrder($cates, $parent_id = 0)
    {
        foreach ($cates as $key => $cate) {
            $cate_info = $this->find($cate->id);
            $cate_info->parent_id = $parent_id;
            $cate_info->order = $key+1;
            if ($cate_info->save() && !empty($cate->children)) {
                $this->saveCateOrder($cate->children, $cate->id);
            }
        }
        return true;
    }
}

<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ArticleTagRepository;
use App\Models\ArticleTag;
use App\Repositories\Validators\ArticleTagValidator;

/**
 * Class ArticleTagRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ArticleTagRepositoryEloquent extends BaseRepository implements ArticleTagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ArticleTag::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 保存标签
     * @param $data object 保存数据信息
     * @return int 标签ID
     * */
    public function saveTag($data)
    {
        $this->model->name = $data->name;
        $this->model->display_name = $data->display_name;
        $this->model->save();
        return $this->model->id;
    }

    /**
     * 更新标签
     * @param $id int 标签ID
     * @param $data object 数据
     * @return int 标签ID
     * */
    public function updateTag($id, $data)
    {
        $tag = $this->find($id);
        $tag->name = $data->name;
        $tag->display_name = $data->display_name;
        $tag->save();
        return $tag->id;
    }
}

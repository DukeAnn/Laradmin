<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Article extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

    /*
     * 多对多关联分类表
     * */
    public function categories()
    {
        return $this->belongsToMany('App\Models\ArticleCategory', 'article_cate')->using('App\Models\ArticleCate');
    }

    /*
   * 多对多关联标签表
   * */
    public function tags()
    {
        return $this->belongsToMany('App\Models\ArticleTag', 'article_tag');
    }

    /**
     * 检查文章是否属于该分类
     * @param $category_id int 分类ID
     * @return bool
     * */
    public function hasCategory($category_id)
    {
        $result = $this->categories()->where('article_category_id', $category_id)->first();
        if (empty($result)) {
            return false;
        }
        return true;
    }

    /**
     * 检查文章是否有此标签
     * @param $tag_id int 标签ID
     * @return bool
     * */
    public function hasTag($tag_id)
    {
        $result = $this->tags()->where('article_tag_id', $tag_id)->first();
        if (empty($result)) {
            return false;
        }
        return true;
    }
}

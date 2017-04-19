<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ArticleCategory extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

    /*
     * 多对多关联文章表
     * */
    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_cate')->using('App\Models\ArticleCate');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleCate extends Pivot
{

    protected $table = 'article_cate';

    // 不自动维护时间戳
    public $timestamps = false;

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    public $fillable = ['article_category_id', 'article_id'];
    
    /*
     * 删除原有绑定
     * */
    public function detach()
    {
        
    }
}

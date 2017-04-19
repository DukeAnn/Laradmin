<?php
/**
 * 文章，分类，标签关联服务
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2017/4/10 0010
 * Time: 14:17
 * @author DukeAnn
 */

namespace App\Services;

use App\Repositories\Eloquent\ArticleCategoryRepositoryEloquent;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\ArticleTagRepositoryEloquent;
use Storage;

class ArticleCateTag
{
    /**
     * @var ArticleRepositoryEloquent
     * */
    protected $articleRepositoryEloquent;

    /**
     * @var ArticleCategoryRepositoryEloquent
     * */
    protected $articleCategoryRepositoryEloquent;

    /**
     * @var ArticleTagRepositoryEloquent
     * */
    protected $articleTagRepositoryEloquent;

    public function __construct(ArticleRepositoryEloquent $articleRepositoryEloquent, ArticleCategoryRepositoryEloquent $articleCategoryRepositoryEloquent, ArticleTagRepositoryEloquent $articleTagRepositoryEloquent)
    {
        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->articleCategoryRepositoryEloquent = $articleCategoryRepositoryEloquent;
        $this->articleTagRepositoryEloquent = $articleTagRepositoryEloquent;
    }

    /**
     * 获取文章信息
     * @param $id int 文章ID
     * @return object 文章信息
     * */
    public function getArticleInfo($id)
    {
        $article = $this->articleRepositoryEloquent->find($id);
        // 获取图片地址
        if (!empty($article->article_image)) {
            $article->article_image = env('APP_URL').Storage::url($article->article_image);
        }
        return $article;
    }

    /*
     * 获取文章发布页面的全部分类和标签
     * */
    public function getAllCateTag()
    {
        $cates = $this->articleCategoryRepositoryEloquent->getAllCate();
        $tags = $this->articleTagRepositoryEloquent->all();
        return compact('cates','tags');
    }

    /**
     * 保存文章
     * @param $data object 提交的文章数据
     * @return bool
     * */
    public function saveArticle($data)
    {
        $cates = $data->cates;
        $tags = $data->tags;
        // 创建文章，获取ID
        $article_id = $this->articleRepositoryEloquent->saveArticle($data);
        // 文章和分类绑定
        if ($article_id && !empty($cates)) {
            $this->boundCate($cates, $article_id);
        }
        // 文章和标签绑定
        if ($article_id && !empty($tags)) {
            $this->boundTag($tags, $article_id);
        }

        return true;
    }

    /**
     * 更新文章
     * @param $id int 文章ID
     * @param $data object 文章内容request
     * @return bool
     * */
    public function updateArticle($id, $data)
    {
        $cates = $data->cates;
        $tags = $data->tags;
        $article_id = $this->articleRepositoryEloquent->updateArticle($id, $data);
        // 文章和分类绑定
        if ($article_id && !empty($cates)) {
            $this->boundCate($cates, $article_id);
        }
        // 文章和标签绑定
        if ($article_id && !empty($tags)) {
            $this->boundTag($tags, $article_id);
        }
        return true;
    }
    
    /**
     * 文章和分类绑定,创建和更新
     * @param $cates array 分类ID
     * @param $article_id int 文章ID
     * */
    protected function boundCate($cates, $article_id)
    {
        $article = $this->articleRepositoryEloquent->find($article_id);
        $article->categories()->sync($cates);
    }

    /*
     * 发布文章和标签绑定
     * @param $tags array 标签ID
     * @param $article_id int 文章ID
     * */
    public function boundTag($tags, $article_id)
    {
        $article = $this->articleRepositoryEloquent->find($article_id);
        $article->tags()->sync($tags);
    }

    /**
     * 删除文章
     * @param $id int 删除文章ID
     * */
    public function deleteArticle($id)
    {
        $article = $this->articleRepositoryEloquent->find($id);
        // 解绑分类
        $article->categories()->sync([]);
        // 解绑标签
        $article->tags()->sync([]);
        // 删除文章
        return $article->delete();
    }

    /**
     * 删除分类，删除该分类与文章的关系
     * @param $id int 分类ID
     * */
    public function deleteCategory($id)
    {
        $category = $this->articleCategoryRepositoryEloquent->find($id);
        // 解绑文章
        $category->articles()->sync([]);
        $child = $this->articleCategoryRepositoryEloquent->findWhere(['parent_id' => $category->id]);
        if ($child) {
            foreach ($child as $value) {
                $this->deleteCategory($value->id);
            }
        }
        return $category->delete();
    }

    /**
     * 删除标签，删除该标签与文章的关系
     * @param $id int 分类ID
     * */
    public function deleteTag($id)
    {
        $tag = $this->articleTagRepositoryEloquent->find($id);
        $tag->articles()->sync([]);
        return $tag->delete();
    }
}
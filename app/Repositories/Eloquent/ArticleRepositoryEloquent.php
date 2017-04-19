<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ArticleRepository;
use App\Models\Article;
use App\Repositories\Validators\ArticleValidator;

/**
 * Class ArticleRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ArticleRepositoryEloquent extends BaseRepository implements ArticleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 保存文章
     * @param $article_info \Illuminate\Http\Response 文章信息
     * @return int 文章ID
     * */
    public function saveArticle($article_info)
    {
        $this->model->title = $article_info->title;
        $this->model->abstract = $article_info->abstract;
        $this->model->content = $article_info->input('editormd-html-code');
        $this->model->content_md = $article_info->input('editormd-markdown-doc');
        $this->model->article_image = $article_info->article_image;
        $this->model->article_status = 1;
        $this->model->comment_status = 1;
        $this->model->author = $article_info->author;
        $this->model->user_id = $article_info->user_id;
        $this->model->save();
        return $this->model->id;
    }

    /*
     * 更细文章
     * */
    public function updateArticle($id, $article_info)
    {
        $article = $this->find($id);
        $article->title = $article_info->title;
        $article->abstract = $article_info->abstract;
        $article->content = $article_info->input('editormd-html-code');
        $article->content_md = $article_info->input('editormd-markdown-doc');
        if (!empty($article_info->article_image)) {
            $article->article_image = $article_info->article_image;
        }
        $article->article_status = 1;
        $article->comment_status = 1;
        $article->save();
        return $article->id;
    }
    
    /**
     * 清除文章和全部分类关系
     * @param $categories object 关系
     * */
   /* public function detachCategories($categories)
    {
        foreach ($categories as $category) {
            $this->detachCategory($category);
        }
    }*/
    
    /**
     * 清除文章和单一分类关系
     * @param object|array $category
     * */
    /*public function detachCategory($category)
    {
        if (is_object($category)) {
            $category = $category->getKey();
        }
        if (is_array($category)) {
            $category = $category['id'];
        }
        $this->model->categories()->detach($category);
    }*/
}

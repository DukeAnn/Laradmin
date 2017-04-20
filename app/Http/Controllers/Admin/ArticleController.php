<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Http\Requests\ArticlePost;
use Auth;
use App\Services\ImageUpload;
use App\Repositories\Eloquent\ImageRepositoryEloquent;
use App\Services\ArticleCateTag;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Storage;

class ArticleController extends Controller
{
    protected $articleRepositoryEloquent;

    protected $imageUpload;

    protected $imageRepositoryEloquent;

    protected $articleCateTag;

    public function __construct(ArticleRepositoryEloquent $articleRepositoryEloquent, ImageUpload $imageUpload, ImageRepositoryEloquent $imageRepositoryEloquent, ArticleCateTag $articleCateTag)
    {
        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->imageUpload = $imageUpload;
        $this->imageRepositoryEloquent = $imageRepositoryEloquent;
        $this->articleCateTag = $articleCateTag;
    }
    /**
     * 文章列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.article.index');
    }

    /**
     * 创建文章
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 读取全部分类和标签
        $data = $this->articleCateTag->getAllCateTag();
        return view('admin.article.create', ['cates' => $data['cates'], 'tags' => $data['tags'], 'is_edit' => false]);
    }

    /**
     * 保存文章
     *
     * @param  \App\Http\Requests\ArticlePost
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlePost $request)
    {
        $article_info = $request;
        // 获取发布人信息
        $article_info->user_id = Auth::user()->id;
        $article_info->author = Auth::user()->name;
        // 上传图片
        if ($request->hasFile('article_image')) {
            $upload_status = $this->imageUpload->uploadImage($request->file('article_image'));
            $file_arr = $upload_status['filename'];
            // 保存到图片表
            $insert_id = $this->saveImageInfo($file_arr);
            $article_info->article_image = $file_arr['small'];
        }
        // 保存文章，分类，标签
        $result = $this->articleCateTag->saveArticle($article_info);
        if ($result) {
            return redirect()->route('article.index');
        }
    }

    /**
     * 保存图片信息到数据库
     * @param $file_arr array
     * @return string 插入ID
     * */
    protected function saveImageInfo($file_arr)
    {
        $insert_id = $this->imageRepositoryEloquent->saveImage($file_arr, Auth::user());
        return $insert_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $article = $this->articleCateTag->getArticleInfo($id);
        // 读取文章分类
        $data = $this->articleCateTag->getAllCateTag();
        return view('admin.article.create', ['cates' => $data['cates'], 'tags' => $data['tags'], 'article' => $article, 'is_edit' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticlePost
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticlePost $request, $id)
    {
        $article_info = $request;
        // 上传图片
        if ($request->hasFile('article_image')) {
            $upload_status = $this->imageUpload->uploadImage($request->file('article_image'));
            $file_arr = $upload_status['filename'];
            // 保存到图片表
            $insert_id = $this->saveImageInfo($file_arr);
            $article_info->article_image = $file_arr['small'];
        }
        $result = $this->articleCateTag->updateArticle($id, $article_info);
        if ($result) {
            return redirect()->route('article.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->articleCateTag->deleteArticle($id);
        if ($result) {
            return response()->json(['state' => 'success']);
        }
    }

    /*
     * ajax获取文章列表
     * */
    public function getArticles()
    {
        $articles = $this->articleRepositoryEloquent->all();
        $datatables_json = Datatables::of($articles)
        ->addColumn('action', function ($article){
        $edit_url = route('article.edit', $article->id);
        $delete_url = route('article.destroy', $article->id);
        return <<<Eof
                <a href="javascript:;" class="btn btn-outline dark btn-sm black mt-sweetalert"
                                                            style="margin-bottom: 0;"
                                                           data-title="确定要删除该文章吗？"
                                                           data-message="（文章中的图片请在媒体库删除）"
                                                           data-type="warning"
                                                           data-allow-outside-click="true"
                                                           data-show-cancel-button="true"
                                                           data-cancel-button-text="点错了"
                                                           data-cancel-button-class="btn-danger"
                                                           data-show-confirm-button="true"
                                                           data-confirm-button-text="确定"
                                                           data-confirm-button-class="btn-info"
                                                           data-popup-title-success="删除成功"
                                                           data-close-on-cancel="true"
                                                           data-close-on-confirm="false"
                                                           data-show-loader-on-confirm="true"
                                                           data-ajax-url="{$delete_url}"
                                                           data-remove-dom="article_li_"
                                                           data-id="{$article->id}"
                                                        >
                                                            <i class="fa fa-trash-o"></i>
                                                            删除
                                                        </a>
                                                        <a href="{$edit_url}" class="btn btn-outline green btn-sm purple"><i class="fa fa-edit"></i>编辑</a>
Eof;
    })
        ->addColumn('cate', function ($article) {
            $categories = '';
            if(!empty($article->categories)) {
                foreach($article->categories as $key => $cate) {
                    $categories .= '<span class="label label-sm label-info">' .htmlspecialchars($cate->name) . '</span>&nbsp;';
                }
            } else {
                $categories =  '<span class="label label-sm label-warning">未分类</span>';
            }
            return $categories;
        })
        ->rawColumns(['cate', 'action'])
        ->setRowId(function ($article) {
            return 'article_li_'.$article->id;
        })
        ->make(true);
        return $datatables_json;
    }
    
    /**
     * MKDown 图片上传
     * @param $request Request 上传请求
     * @return mixed
     * */
    public function uploadImage(Request $request)
    {
        $json = [
            'filename' => '',
            'success' => 0,
            'message' => '失败',
            'url' => '',
        ];
        // 上传图片
        if ($request->hasFile('editormd-image-file')) {
            $upload_status = $this->imageUpload->uploadImage($request->file('editormd-image-file'));
            $file_arr = $upload_status['filename'];
            // 保存到图片表
            $insert_id = $this->saveImageInfo($file_arr);
            $realpayh = env('APP_URL').Storage::url($file_arr['original']);
            $json = array_replace($json, ['success' => 1, 'url' => $realpayh, 'message' => '上传成功', 'filename' => $realpayh]);
        }
        return response()->json($json);
    }
}

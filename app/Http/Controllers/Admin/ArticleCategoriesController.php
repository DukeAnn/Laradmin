<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleCategoriesPost;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\ArticleCategoryRepositoryEloquent;
use Illuminate\Http\Request;
use App\Services\ArticleCateTag;

class ArticleCategoriesController extends Controller
{

    protected $articleCategoryRepositoryEloquent;

    protected $articleCateTag;

    public function __construct(ArticleCategoryRepositoryEloquent $articleCategoryRepositoryEloquent, ArticleCateTag $articleCateTag)
    {
        $this->articleCategoryRepositoryEloquent = $articleCategoryRepositoryEloquent;
        $this->articleCateTag = $articleCateTag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate_list = $this->articleCategoryRepositoryEloquent->getAllCate();
        return view('admin.articel_categories.index', compact('cate_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model_cate = $this->articleCategoryRepositoryEloquent->model();
        $cate_first = $model_cate::where('parent_id', 0)->orderBy('order', 'asc')->get();
        return view('admin.articel_categories.create', compact('cate_first'));
    }

    /**
     * 保存分类
     *
     * @param  \App\Http\Requests\ArticleCategoriesPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCategoriesPost $request)
    {
        $responseData = $this->articleCategoryRepositoryEloquent->saveCate($request);
        return response()->json($responseData);
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
     * 更新分类页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate_info = $this->articleCategoryRepositoryEloquent->find($id);
        return view('admin.articel_categories.edit', compact('cate_info'));
    }

    /**
     * 更新分类
     *
     * @param  \App\Http\Requests\ArticleCategoriesPost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCategoriesPost $request, $id)
    {
        $responseData = $this->articleCategoryRepositoryEloquent->updateCate($id, $request);
        return response()->json($responseData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->articleCateTag->deleteCategory($id);
        return response()->json(['state' => 'success']);
    }

    /**
     * 保存排序
     * \Illuminate\Http\Request $request
     * */
    public function saveOrder(Request $request)
    {
        if (!empty($request->cate)) {
            $cate = json_decode($request->cate);
            $this->articleCategoryRepositoryEloquent->saveCateOrder($cate);
            return response()->json(['state' => 'success']);
        }
    }
}

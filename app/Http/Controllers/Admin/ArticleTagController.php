<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\ArticleTagRepositoryEloquent;
use Yajra\Datatables\Facades\Datatables;
use App\Services\ArticleCateTag;

class ArticleTagController extends Controller
{
    protected $articleTagRepositoryEloquent;

    protected $articleCateTag;

    public function __construct(ArticleTagRepositoryEloquent $articleTagRepositoryEloquent, ArticleCateTag $articleCateTag)
    {
        $this->articleTagRepositoryEloquent = $articleTagRepositoryEloquent;
        $this->articleCateTag = $articleCateTag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.article_tags.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'display_name' => 'allow_letter'
            ],
            [
                'name.required' => '请填写标签名',
                'display_name.allow_letter' => '英文别名只能是字母或\'-\',\' _\'',
            ]
        );
        $result = $this->articleTagRepositoryEloquent->saveTag($request);
        if ($result) {
            $data = [
                'code' => 0,
                'message' => '添加成功'
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => '添加失败'
            ];
        }
        return response()->json($data);
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
        $tag = $this->articleTagRepositoryEloquent->find($id);
        $data = [
            'code' => 0,
            'data' => [
                'tag' => $tag
            ]
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'display_name' => 'allow_letter'
            ],
            [
                'name.required' => '请填写标签名',
                'display_name.allow_letter' => '英文别名只能是字母或\'-\',\' _\'',
            ]
        );
        $result = $this->articleTagRepositoryEloquent->updateTag($id, $request);
        if ($result) {
            $data = [
                'code' => 0,
                'message' => '修改成功'
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => '修改失败'
            ];
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->articleCateTag->deleteTag($id);
        if ($result) {
            return response()->json(['state' => 'success']);
        }
    }

    /*
     * ajax获取列表
     * */
    public function getTags()
    {
        $tags = $this->articleTagRepositoryEloquent->all();
        $datatables_json = Datatables::of($tags)
            ->addColumn('action', function ($tag){
                $edit_url = route('article_tag.edit', $tag->id);
                $delete_url = route('article_tag.destroy', $tag->id);
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
                                                           data-remove-dom="tag_li_"
                                                           data-id="{$tag->id}"
                                                        >
                                                            <i class="fa fa-trash-o"></i>
                                                            删除
                                                        </a>
                                                        <a href="javascript:;" onclick="getTag({$tag->id})" class="btn btn-outline green btn-sm purple"><i class="fa fa-edit"></i>编辑</a>
Eof;
            })
            ->rawColumns(['action'])
            ->setRowId(function ($tag) {
                return 'tag_li_'.$tag->id;
            })
            ->make(true);
        return $datatables_json;
    }
}

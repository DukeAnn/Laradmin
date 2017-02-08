<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.user_list');
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->delete();
        return response()->json(['code' => 0, 'message' => 'success']);
    }

    /**
     * ajax获取权限列表数据
     * */
    public function getUsers()
    {
        $users = User::all();
        $datatables_json = Datatables::of($users)
            ->addColumn('action', function ($user){
            $edit_url = route('user.edit', $user->id);
            $delete_url = route('user.destroy', $user->id);
            return <<<Eof
                <a href="javascript:;" class="btn btn-outline dark btn-sm black mt-sweetalert"
                                                            style="margin-bottom: 0;"
                                                           data-title="确定要删除该用户吗？"
                                                           data-message="（该用户的所有数据会被删除）"
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
                                                           data-remove-dom="user_li_"
                                                           data-id="{$user->id}"
                                                        >
                                                            <i class="fa fa-trash-o"></i>
                                                            删除
                                                        </a>
                                                        <a href="{$edit_url}" class="btn btn-outline green btn-sm purple"><i class="fa fa-edit"></i>编辑</a>
Eof;
        })
            ->addColumn('role', function ($user) {
                $roles = '';
                if(!empty($user->roles)) {
                    foreach($user->roles as $role) {
                        $roles .= $role->display_name.'&nbsp;';
                    }
                } else {
                    $roles =  '无角色';
                }
                return '<span class="label label-sm label-success">' . $roles . '</span>';
            })
            ->setRowId(function ($user) {
                return 'user_li_'.$user->id;
            })
            ->make(true);

        return $datatables_json;
    }
}

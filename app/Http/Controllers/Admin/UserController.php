<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Models\Role;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepositoryEloquent;

    public function __construct(UserRepositoryEloquent $userRepositoryEloquent)
    {
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }
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
        $user = $this->userRepositoryEloquent->find($id);
        // 查询用户组
        $roles = Role::all();

        $data = [
            'roles' => $roles,
            'user' => $user,
        ];
        return view('admin.user.user_edit', $data);
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
        $result = $this->userRepositoryEloquent->editUserRole($id, $request->role_id);
        if ($result) {
            return redirect()->route('user.index');
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
        $user = $this->userRepositoryEloquent->find($id);
        if ($user->hasRole('admin')) {
            return response()->json(['code' => 1, 'error' => '删除管理员？搞事情？'], 422);
        }
        if ($user->id == \Auth::id()){
            return response()->json(['code' => 1, 'error' => '不允许删除自己？搞事情？'], 422);
        }
        $user->delete();
        return response()->json(['code' => 0, 'message' => 'success']);
    }

    /**
     * ajax获取权限列表数据
     * */
    public function getUsers()
    {
        $users = User::query();
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
            ->addColumn('name', function ($user) {
                return htmlspecialchars($user->name);
            })
            ->addColumn('email', function ($user) {
                return htmlspecialchars($user->email);
            })
            ->addColumn('role', function ($user) {
                $roles = '';
                if(!empty($user->roles)) {
                    foreach($user->roles as $role) {
                        $roles .= htmlspecialchars($role->display_name).'&nbsp;';
                    }
                } else {
                    $roles =  '无角色';
                }
                return '<span class="label label-sm label-success">' . $roles . '</span>';
            })
            ->rawColumns(['role', 'action'])
            ->setRowId(function ($user) {
                return 'user_li_'.$user->id;
            })
            ->make(true);

        return $datatables_json;
    }
}

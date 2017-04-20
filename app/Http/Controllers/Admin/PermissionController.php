<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Http\Requests\PermissionPost;
use Yajra\Datatables\Facades\Datatables;
use App\Models\Role;

class PermissionController extends Controller
{
    /**
     * 用户权限组
     * @var PermissionPost
     * */
    protected $model_permission;

    /**
     * 依赖注入
     * @param Permission $permission
     * */
    public function __construct(Permission $permission)
    {
        $this->model_permission = $permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.permissions.permissions_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.permissions.permissions_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PermissionPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionPost $request)
    {
        $permission_id = $this->model_permission->createPermission($request);

        if ($permission_id) {
            // 绑定到最高权限组
            $role = Role::findOrFail(1);
            $role->attachPermission(array('id' => $permission_id));

            return redirect()->route('permissions.index');
        }
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
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.permissions_edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PermissionPost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionPost $request, $id)
    {
        if ($this->model_permission->updatePermission($id, $request)) {
            return redirect()->route('permissions.index');
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
        $this->model_permission->deletePermission($id);
        return response()->json(['state' => 'success']);

    }
    
    /**
     * ajax获取权限列表数据
     * */
    public function getPermissions()
    {
        $permissions = Permission::select([
            'id',
            'name',
            'uri',
            'display_name',
            'created_at',
            'updated_at'
        ]);
        $datatables_json = Datatables::of($permissions)->addColumn('action', function ($permission){
            $edit_url = route('permissions.edit', $permission->id);
            $delete_url = route('permissions.destroy', $permission->id);
            return <<<Eof
                <a href="javascript:;" class="btn btn-outline dark btn-sm black mt-sweetalert"
                                                            style="margin-bottom: 0;"
                                                           data-title="确定要删除该用户权限吗？"
                                                           data-message="（该用户权限关联的用户组将会被解绑）"
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
                                                           data-remove-dom="permission_li_"
                                                           data-id="{$permission->id}"
                                                        >
                                                            <i class="fa fa-trash-o"></i>
                                                            删除
                                                        </a>
                                                        <a href="{$edit_url}" class="btn btn-outline green btn-sm purple"><i class="fa fa-edit"></i>编辑</a>
Eof;
        })
            ->rawColumns(['action'])
            ->setRowId(function ($permission) {
                return 'permission_li_'.$permission->id;
            })
            ->make(true);

        return $datatables_json;
    }
}

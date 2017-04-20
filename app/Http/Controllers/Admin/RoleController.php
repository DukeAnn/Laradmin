<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RolePost;
use App\Models\Role;
use App\Models\Permission;
use App\Presenters\Admin\rolePermissionsPresenter;

class RoleController extends Controller
{
    /**
     * 用户权限组
     * @var Role
     * */
    protected $model_role;

    /**
     * 依赖注入
     * @param Role $role
     * */
    public function __construct(Role $role)
    {
        $this->model_role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->model_role->getRoleList(getSetting('admin_pages_length'));
        return view('admin.role.role_list', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where([])
            ->orderBy('name', 'desc')
            ->get();
        return view('admin.role.role_add', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RolePost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolePost $request)
    {
        $this->model_role->createRole($request);
        return redirect('admin/role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role_info = Role::findOrFail($id);
        $rolePerms = new rolePermissionsPresenter();
        $perms = $rolePerms->groupPermissions($role_info->perms);
        $role = [
            'role' => $role_info,
            'perms' =>$perms
        ];
        return response()->json($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == 1) {
            //返回session('error');到原页面
            return back()->withInput()->withError('no_permissions');
        }
        $role = Role::findOrFail($id);
        $permissions = Permission::where([])
            ->orderBy('name', 'desc')
            ->get();
        return view(
            'admin.role.role_edit',
            [
                'role'  => $role,
                'permissions' => $permissions
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RolePost  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolePost $request, $id)
    {
        $this->model_role->updateRole($id, $request);
        return redirect('admin/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            return response()->json(['code' => 1, 'error' => '删除最高管理组？搞事情？'], 422);
        }
        $this->model_role->deleteRole($id);
        return response()->json(['state' => 'success']);
    }
}

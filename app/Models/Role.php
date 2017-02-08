<?php
/**
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2016/11/14 0014
 * Time: 9:28
 * @author ADKi
 */
namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * 创建用户组
     * @param object $request
     * */
    public function createRole($request)
    {
        $this->name = $request->name;
        $this->display_name = $request->display_name;
        $this->description = $request->description;
        $this->save();
        if (is_array($request->permission)) {
            $permissions = [];
            foreach ($request->permission as $id) {
                $permissions[] = Permission::findOrFail($id);
            }
            $this->attachPermissions($permissions);
        }
    }

    /**
     * 更新用户组
     * @param int $id
     * @param object $request
     * */
    public function updateRole($id, $request)
    {
        $role = self::findOrFail($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        //清除以前的权限
        $role->detachPermissions($role->perms);
        //写入新权限
        if (is_array($request->permission)) {
            $permissions = [];
            foreach ($request->permission as $id) {
                $permissions[] = Permission::findOrFail($id);
            }
            $role->attachPermissions($permissions);
        }
    }

    /**
     * 删除用户组
     * @param int $id
     * */
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        // Force Delete
        $role->users()->sync([]); // 同步清除角色下的用户关联
        $role->perms()->sync([]); // 同步清除角色下的权限关联

        $role->forceDelete(); // 删除角色
    }

    /**
     * 查询角色列表并分页
     * @param int $page 每页显示数据数量
     * @param array $condition 查询条件
     * */
    public function getRoleList($page, array $condition = [])
    {
        return $this->where($condition)->paginate($page);
    }

    /**
     *
     * */
}
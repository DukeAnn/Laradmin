<?php
/**
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2016/11/14 0014
 * Time: 9:31
 * @author ADKi
 */
namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * 创建用户权限
     * @param object $request
     * @return bool
     * */
    public function createPermission($request)
    {
        $this->name = $request->name;
        $this->display_name = $request->display_name;
        $this->description  = $request->description;
        $this->uri  = $request->uri;
        $this->save();
        return $this->id;
    }

    /**
     * 更新用户权限
     * @param int $id
     * @param object $request
     * */
    public function updatePermission($id, $request)
    {
        $permission = self::findOrFail($id);
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->uri = $request->uri;
        return $permission->save();
    }

    /**
     * 删除用户权限
     * @param int $id
     * */
    public function deletePermission($id)
    {
        $permission = self::findOrFail($id);
        //删除跟用户角色的关联
        $permission->roles()->sync([]);

        $permission->forceDelete();
    }

}

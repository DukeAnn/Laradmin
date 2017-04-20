<?php
/**
 * 用户组选权限html组件
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2016/11/23 0023
 * Time: 21:00
 */

namespace App\Presenters\Admin;

class rolePermissionsPresenter
{
    /**
     * 将用户权限分组排列
     * @param array $permissions 权限
     * @param array $rolePer 用户组
     * @return string
     * */
    public function getPermissions($permissions, $rolePer = [])
    {

        $html = '';
        $permissions = $this->groupPermissions($permissions);
        $rolePer = $this->getRolePermissions($rolePer);
        foreach ($permissions as $key => $permission) {
            $key = htmlspecialchars($key);
            $html .= "<tr><td><span class='label label-sm label-success'>".$key." </span></td><td>";
            foreach ($permission as $value) {
                $display_name = htmlspecialchars($value['display_name']);
                $checked = in_array($value['id'], $rolePer) ? 'checked' : '';
                $html .= <<<Eof
                <div class="md-checkbox col-md-4">
                  <input type="checkbox" id="permission_{$value['id']}" class="md-check" value="{$value['id']}" name="permission[]" {$checked}>
                  <label for="permission_{$value['id']}">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> {$display_name}
                  </label>
                </div>
Eof;
            }
            $html .= '</td></tr>';
        }
        return $html;
    }

    /**
     * 权限组重新排序，按权限分组
     * @param array $permissions
     * @return array
     * */
    public function groupPermissions($permissions)
    {
        $array = [];
        foreach ($permissions as $permission) {
            array_set($array, $permission->name, $permission);
        }
        return $array;
    }

    /**
     * 获取当前用户组权限ID数组
     * @param object $rolePer
     * @return array
     * */
    public function getRolePermissions($rolePer)
    {
        $array = [];
        if (!empty($rolePer)) {
            foreach ($rolePer as $permission) {
                $array[] = $permission->id;
            }
        }
        return $array;
    }

}
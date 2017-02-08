<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //////////////////
        ///登录后台权限 //
        /////////////////
        Permission::create([
            'display_name' => '登录后台权限',
            'name' => 'system.login',
            'description' => '登录后台权限',
            'uri' => 'login',
        ]);
        Permission::create([
            'display_name' => '后台首页',
            'name' => 'system.index',
            'description' => '后台首页',
            'uri' => 'admin.index',
        ]);

       /**
        * 菜单
        * */
        Permission::create([
            'display_name' => '显示菜单列表',
            'name' => 'menu.list',
            'description' => '显示菜单列表',
            'uri' => 'menutable.index',
        ]);

        Permission::create([
            'display_name' => '创建菜单',
            'name' => 'menu.create',
            'description' => '创建菜单',
            'uri' => 'menutable.create',
        ]);

        Permission::create([
            'display_name' => '删除菜单',
            'name' => 'menu.destroy',
            'description' => '删除菜单',
            'uri' => 'menutable.destroy',
        ]);

        Permission::create([
            'display_name' => '修改菜单',
            'name' => 'menu.edit',
            'description' => '修改菜单',
            'uri' => 'menutable.edit',
        ]);

        Permission::create([
            'display_name' => '查看菜单',
            'name' => 'menu.show',
            'description' => '查看菜单',
            'uri' => 'menutable.show',
        ]);

        Permission::create([
            'display_name' => '菜单创建POST',
            'name' => 'menu.store',
            'description' => '菜单创建POST',
            'uri' => 'menu.store',
        ]);

        Permission::create([
            'display_name' => '菜单更新PUT',
            'name' => 'menu.update',
            'description' => '菜单更新PUT',
            'uri' => 'request',
        ]);

        Permission::create([
            'display_name' => '保存菜单排序',
            'name' => 'menu.saveMenuOrder',
            'description' => '保存菜单排序',
            'uri' => 'menutable.saveMenuOrder',
        ]);

        /**
         * 角色
         */
        Permission::create([
            'display_name' => '显示角色列表',
            'name' => 'role.list',
            'description' => '显示角色列表',
            'uri' => 'role.index',
        ]);

        Permission::create([
            'display_name' => '创建角色',
            'name' => 'role.create',
            'description' => '创建角色',
            'uri' => 'role.create',
        ]);

        Permission::create([
            'display_name' => '删除角色',
            'name' => 'role.destroy',
            'description' => '删除角色',
            'uri' => 'role.destroy',
        ]);

        Permission::create([
            'display_name' => '修改角色',
            'name' => 'role.edit',
            'description' => '修改角色',
            'uri' => 'role.edit',
        ]);

        Permission::create([
            'display_name' => '查看角色权限',
            'name' => 'role.show',
            'description' => '查看角色权限',
            'uri' => 'role.show',
        ]);

        Permission::create([
            'display_name' => '用户角色创建POST',
            'name' => 'role.store',
            'description' => '用户角色创建POST',
            'uri' => 'request',
        ]);

        Permission::create([
            'display_name' => '用户角色更新PUT',
            'name' => 'role.update',
            'description' => '用户角色更新PUT',
            'uri' => 'request',
        ]);

        /**
         * 权限
         */
        Permission::create([
            'display_name' => '显示权限列表',
            'name' => 'permission.list',
            'description' => '显示权限列表',
            'uri' => 'permissions.index',
        ]);

        Permission::create([
            'display_name' => '创建权限',
            'name' => 'permission.create',
            'description' => '创建权限',
            'uri' => 'permissions.create',
        ]);

        Permission::create([
            'display_name' => '删除权限',
            'name' => 'permission.destroy',
            'description' => '删除权限',
            'uri' => 'permissions.destroy',
        ]);

        Permission::create([
            'display_name' => '修改权限',
            'name' => 'permission.edit',
            'description' => '修改权限',
            'uri' => 'permissions.edit',
        ]);

        Permission::create([
            'display_name' => '用户权限创建POST',
            'name' => 'permission.store',
            'description' => '用户权限创建POST',
            'uri' => 'request',
        ]);

        Permission::create([
            'display_name' => '用户权限更新PUT',
            'name' => 'permission.update',
            'description' => '用户权限更新PUT',
            'uri' => 'request',
        ]);

        /**
         * 用户
         */
        Permission::create([
            'display_name' => '显示用户列表',
            'name' => 'user.list',
            'description' => '显示用户列表',
            'uri' => 'user.index',
        ]);

        Permission::create([
            'display_name' => '创建用户',
            'name' => 'user.create',
            'description' => '创建用户',
            'uri' => 'user.create',
        ]);

        Permission::create([
            'display_name' => '修改用户',
            'name' => 'user.edit',
            'description' => '修改用户',
            'uri' => 'user.edit',
        ]);

        Permission::create([
            'display_name' => '删除用户',
            'name' => 'user.destroy',
            'description' => '删除用户',
            'uri' => 'user.destroy',
        ]);

        Permission::create([
            'display_name' => '查看用户信息',
            'name' => 'user.show',
            'description' => '查看用户信息',
            'uri' => 'user.show',
        ]);

        Permission::create([
            'display_name' => '用户创建POST',
            'name' => 'user.store',
            'description' => '用户创建POST',
            'uri' => 'request',
        ]);

        Permission::create([
            'display_name' => '用户更新PUT',
            'name' => 'user.update',
            'description' => '用户更新PUT',
            'uri' => 'request',
        ]);

        /**
         * 日志
         */
        Permission::create([
            'display_name' => '显示日志仪表盘',
            'name' => 'log.dash',
            'description' => '显示日志仪表盘',
            'uri' => 'log.index',
        ]);

        Permission::create([
            'display_name' => '查看日志',
            'name' => 'log.filter',
            'description' => '查看日志',
            'uri' => 'log.filter',
        ]);

        Permission::create([
            'display_name' => '日志下载',
            'name' => 'log.download',
            'description' => '日志下载',
            'uri' => 'log.download',
        ]);

        Permission::create([
            'display_name' => '日志删除',
            'name' => 'log.destroy',
            'description' => '日志删除',
            'uri' => 'log.destroy',
        ]);

        /**
         * 父类菜单
         * */
        Permission::create([
            'display_name' => '用户管理',
            'name' => 'parent.user',
            'description' => '用户管理',
            'uri' => 'parent.user',
        ]);

        Permission::create([
            'display_name' => '设置',
            'name' => 'parent.setting',
            'description' => '设置',
            'uri' => 'parent.setting',
        ]);

        Permission::create([
            'display_name' => '系统日志',
            'name' => 'parent.log',
            'description' => '系统日志',
            'uri' => 'parent.log',
        ]);
    }
}

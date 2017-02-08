<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //仪表盘
        Menu::create([
            'parent_id' => 0,
            'order' => 1,
            'name' => '仪表盘',
            'icon' => 'speedometer',
            'uri' => 'parent.admin',
        ]);

        Menu::create([
            'parent_id' => 1,
            'order' => 1,
            'name' => '系统总览',
            'icon' => 'notebook',
            'uri' => 'admin.index',
        ]);

        Menu::create([
            'parent_id' => 1,
            'order' => 2,
            'name' => '图标参考',
            'icon' => 'list',
            'uri' => 'admin.icon',
        ]);

        //用户管理
        Menu::create([
            'parent_id' => 0,
            'order' => 2,
            'name' => '用户管理',
            'icon' => 'settings',
            'uri' => 'parent.user',
        ]);

        Menu::create([
            'parent_id' => 4,
            'order' => 1,
            'name' => '用户列表',
            'icon' => 'list',
            'uri' => 'user.index',
        ]);

        Menu::create([
            'parent_id' => 4,
            'order' => 2,
            'name' => '用户组管理',
            'icon' => 'list',
            'uri' => 'role.index',
        ]);

        Menu::create([
            'parent_id' => 4,
            'order' => 3,
            'name' => '用户组权限',
            'icon' => 'list',
            'uri' => 'permissions.index',
        ]);

        //设置
        Menu::create([
            'parent_id' => 0,
            'order' => 3,
            'name' => '设置',
            'icon' => 'settings',
            'uri' => 'parent.setting',
        ]);

        Menu::create([
            'parent_id' => 8,
            'order' => 1,
            'name' => '编辑菜单',
            'icon' => 'list',
            'uri' => 'menutable.index',
        ]);

        //系统日志
        Menu::create([
            'parent_id' => 0,
            'order' => 3,
            'name' => '系统日志',
            'icon' => 'settings',
            'uri' => 'parent.log',
        ]);

        Menu::create([
            'parent_id' => 10,
            'order' => 1,
            'name' => '仪表盘',
            'icon' => 'speedometer',
            'uri' => 'log.index',
        ]);
    }
}

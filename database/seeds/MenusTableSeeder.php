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
            'id' => 1,
            'parent_id' => 0,
            'order' => 1,
            'name' => '仪表盘',
            'icon' => 'icon-speedometer',
            'uri' => 'parent.admin',
        ]);

        Menu::create([
            'id' => 2,
            'parent_id' => 1,
            'order' => 1,
            'name' => '系统总览',
            'icon' => 'icon-bar-chart',
            'uri' => 'admin.index',
        ]);

        Menu::create([
            'id' => 3,
            'parent_id' => 1,
            'order' => 2,
            'name' => '图标参考',
            'icon' => 'icon-list',
            'uri' => 'icon.index',
        ]);

        //用户管理
        Menu::create([
            'id' => 4,
            'parent_id' => 0,
            'order' => 2,
            'name' => '用户管理',
            'icon' => 'icon-users',
            'uri' => 'parent.user',
        ]);

        Menu::create([
            'id' => 5,
            'parent_id' => 4,
            'order' => 1,
            'name' => '用户列表',
            'icon' => 'icon-user',
            'uri' => 'user.index',
        ]);

        Menu::create([
            'id' => 6,
            'parent_id' => 4,
            'order' => 2,
            'name' => '用户组管理',
            'icon' => 'icon-social-dropbox',
            'uri' => 'role.index',
        ]);

        Menu::create([
            'id' => 7,
            'parent_id' => 4,
            'order' => 3,
            'name' => '用户组权限',
            'icon' => 'icon-user-following',
            'uri' => 'permissions.index',
        ]);

        //设置
        Menu::create([
            'id' => 8,
            'parent_id' => 0,
            'order' => 5,
            'name' => '设置',
            'icon' => 'icon-settings',
            'uri' => 'parent.setting',
        ]);

        Menu::create([
            'id' => 9,
            'parent_id' => 8,
            'order' => 1,
            'name' => '编辑菜单',
            'icon' => 'icon-list',
            'uri' => 'menutable.index',
        ]);

        //系统日志
        Menu::create([
            'id' => 10,
            'parent_id' => 0,
            'order' => 6,
            'name' => '系统日志',
            'icon' => 'icon-note',
            'uri' => 'parent.log',
        ]);

        Menu::create([
            'id' => 11,
            'parent_id' => 10,
            'order' => 1,
            'name' => '仪表盘',
            'icon' => 'icon-speedometer',
            'uri' => 'log.index',
        ]);

        //系统日志
        Menu::create([
            'id' => 12,
            'parent_id' => 0,
            'order' => 4,
            'name' => '多媒体',
            'icon' => 'icon-layers',
            'uri' => 'picture',
        ]);

        Menu::create([
            'id' => 13,
            'parent_id' => 12,
            'order' => 1,
            'name' => '图片管理',
            'icon' => 'icon-picture',
            'uri' => 'picture.index',
        ]);

        Menu::create([
            'id' => 14,
            'parent_id' => 8,
            'order' => 2,
            'name' => '系统设置',
            'icon' => 'icon-settings',
            'uri' => 'setting.index',
        ]);

        Menu::create([
            'id' => 15,
            'parent_id' => 0,
            'order' => 3,
            'name' => '博客管理',
            'icon' => 'icon-book-open',
            'uri' => 'article',
        ]);

        Menu::create([
            'id' => 16,
            'parent_id' => 15,
            'order' => 1,
            'name' => '文章管理',
            'icon' => 'icon-pencil',
            'uri' => 'article.index',
        ]);

        Menu::create([
            'id' => 17,
            'parent_id' => 15,
            'order' => 2,
            'name' => '分类管理',
            'icon' => 'icon-direction',
            'uri' => 'article_categories.index',
        ]);

        Menu::create([
            'id' => 18,
            'parent_id' => 15,
            'order' => 3,
            'name' => '标签管理',
            'icon' => 'icon-tag',
            'uri' => 'article_tag.index',
        ]);
    }
}

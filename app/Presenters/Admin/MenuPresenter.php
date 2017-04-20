<?php
/**
 * admin视图层左侧菜单html组件
 * Created by PhpStorm.
 * User: 雷雷
 * Date: 2016/11/20
 * Time: 22:31
 */

namespace App\Presenters\Admin;

use Entrust;
use App\Models\Permission;
use App\Repositories\Eloquent\MenuRepositoryEloquent;
use Route;

class MenuPresenter
{
    //展开菜单标识
    static private $open;
    //选中菜单标识
    static private $active;
    //递归层数标识
    static private $layer = 0;
    //打开的菜单数组
    static private $parent_key = -1;

    protected $model_menu;

    public function __construct(MenuRepositoryEloquent $menuRepositoryEloquent)
    {
        $this->model_menu = $menuRepositoryEloquent;
    }

    /**
     * 后台左侧菜单，显示激活状态
     * @param array $sidebarMenus 菜单
     * @param int $parent_key 菜单
     * @return string
     * */
    public function sidebarMenuList($sidebarMenus, $parent_key = -1)
    {
        //记录递归层数
        self::$layer++;
        //重排序数组
        $sidebarMenus = array_merge($sidebarMenus);
        $html = '';
        $count = count($sidebarMenus);
        foreach ($sidebarMenus as $key => $menu) {
            //权限验证匹配uri验证uri对应权限
            $permission_info = Permission::where(['uri' => $menu['uri']])->first();
            //不存在权限验证的直接通过
            if (!empty($permission_info)) {
                //用户权限检查，不存在的权限不显示
                if (!Entrust::can($permission_info['name'])) {
                    continue;
                }
            }
            //最后一层会被激活，但不会回进入 if ($menu['child'])
            //切出路由一级前缀
            $uri_arr = explode('.', $menu['uri']);
            //相同菜单前缀保持菜单选中状态
            self::$active = active_class(if_route_pattern([$uri_arr[0].'.*']), 'active open');
            $open_arr[$key] = self::$active;
            if ($count == $key+1) {
                if (in_array('active open', $open_arr)) {
                    //被选中菜单进入
                    self::$open = 'active open';
                    self::$parent_key = $parent_key;
                }
            }
            $icon = htmlspecialchars($menu['icon']);
            $name = htmlspecialchars($menu['name']);
            if ($menu['child']) {
                //存在子菜单递归遍历
                $html_child = $this->sidebarMenuList($menu['child'], $key);
                if (self::$parent_key == $key){
                    $open = self::$open;
                } else {
                    $open = '';
                }
                //如果是第一层，清除父类标识
                if (self::$layer == 1) {
                    self::$parent_key = -1;
                }
                $html .= <<<Eof
                    <li class="nav-item {$open}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="{$icon}"></i>
                            <span class="title">{$name}</span>
                            <span class="arrow {$open}"></span>
                        </a>
                        <ul class="sub-menu">
                            {$html_child}
                        </ul>
                    </li>
Eof;
            } else {
                //不存在子菜单直接输出链接导航，判断路由是否存在
                $url = Route::getRoutes()->getByName($menu['uri']) ? route($menu['uri']) : '#';

                $active = self::$active;
                $html .= <<<Eof
                <li class="nav-item {$active}">
                    <a href="{$url}" class="nav-link">
                        <i class="{$icon}"></i>
                        <span class="title">{$name}</span>
                    </a>
                </li>
Eof;
            }
        }
        //如果无子菜单,并且不是第三级菜单，设置父类ID
        if (self::$parent_key != -1 && self::$layer != 3) {
            self::$parent_key = $parent_key;
        }
        self::$layer--;
        return $html;
    }
    
    /**
     * 菜单排序列表html
     * @param array $menus
     * @return  string
     * */
    public function menuOrderList($menus)
    {
        $html = '<ol class="dd-list">';
        foreach ($menus as $key => $menu) {
            $delete_url = route("menutable.destroy", $menu->id);
            $edit_url = route("menutable.edit", $menu->id);
            $icon = htmlspecialchars($menu->icon);
            $name = htmlspecialchars($menu->name);
            $uri = htmlspecialchars($menu->uri);
            $html .= <<<Eof
                <li class="dd-item" id="menu_li_{$menu->id}" data-id="{$menu->id}">
                    <div class="dd-handle">
                        <i class="{$icon}"></i>&nbsp;{$name}&nbsp;:&nbsp;{$uri}
                        <span class="menu-option action dd-nodrag" data-field-name="_edit">
                            <a href="javascript:;" data-href="{$edit_url}" class="editMenu"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);">
                                <i class="fa fa-trash mt-sweetalert"
                                   data-title="确定要删除此菜单吗？"
                                   data-message="（子菜单会也会被删除）"
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
                                   data-remove-dom="menu_li_"
                                   data-id={$menu->id}
                                >
                                </i>
                            </a>
                        </span>
                    </div>
Eof;
            if(!empty($menu->child)) {
                $html .= $this->menuOrderList($menu->child);
            }
            $html .= '</li>';
        }
        $html .= '</ol>';
        return $html;
    }
}

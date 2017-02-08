<?php
/**
 * Admin后台Sidebar菜单数据
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2016/11/17 0017
 * Time: 22:39
 */

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\Eloquent\MenuRepositoryEloquent;
use Cache;

class SidebarMenuComposer
{
    /**
     * 菜单
     *
     * @var MenuRepositoryEloquent
     */
    protected $model_menu;

    /**
     * 创建一个新的属性composer.
     *
     * @param MenuRepositoryEloquent $menu
     */
    public function __construct(MenuRepositoryEloquent $menu)
    {
        // Dependencies automatically resolved by service container...
        $this->model_menu = $menu;
    }

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('overall_menus', $this->getMenuList());
    }

    /**
     * 从缓存或者数据库中读取左侧菜单数据
     * @return array
     * */
    public function getMenuList()
    {
        if (Cache::has('admin.overall_menus')) {
            $menus = Cache::get('admin.overall_menus');
        } else {
            $menus = $this->model_menu->getAllMenu();
        }
        return $menus;
    }

}
<?php
/**
 * 后台页面面包屑html
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2016/11/30 0030
 * Time: 11:04
 * @author ADKi
 */

namespace App\Presenters\Admin;

use Route;

class CrumbsPresenter
{
    /**
     * 获取网页title
     * */
    public function getTitle()
    {
        //获取当前的菜单名称
        $route_name = Route::currentRouteName();
        if ($route_name) {
            $title = trans('admin/page_heading.' . $route_name . '.name');
            $title .= ' - 后台管理';
        } else {
            $title = '请在语言包添加对应名称，路由不可使用闭包';
        }
        return $title;
    }
    /**
     * 获取页面面包屑
     * */
    public function getCrumbs()
    {
        //获取当前的菜单名称
        $route_name = Route::currentRouteName();
        if ($route_name) {
            $active_arr = explode('.', $route_name);
            //如果不是index 就显示二级面包屑
            if ($active_arr[1] == 'index') {
                //读取对应语言包
                $heading = trans('admin/page_heading.'.$active_arr[0].'.'.$active_arr[1].'.name');
                $html = <<<Eof
                <li>
                    <span>{$heading}</span>
                </li>
Eof;
            } else {
                $header = trans('admin/page_heading.'.$active_arr[0].'.index.name');
                $heading = trans('admin/page_heading.'.$active_arr[0].'.'.$active_arr[1].'.name');
                $url = route($active_arr[0].'.index');
                $html = <<<Eof
                <li>
                    <a href="{$url}">{$header}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>{$heading}</span>
                </li>
Eof;
            }
        } else {
            $html = '请在语言包添加对应名称，路由不可使用闭包';
        }
        return $html;
    }

    /**
     * 获取页面标题
     * */
    public function getPageTitle()
    {
        //获取当前的菜单名称
        $route_name = Route::currentRouteName();
        if ($route_name) {
            $title = trans('admin/page_heading.'.$route_name.'.name');
            $message = trans('admin/page_heading.'.$route_name.'.desc');
            $html = <<<Eof
            <h1 class="page-title"> {$title}
                <small>{$message}</small>
            </h1>
Eof;
        } else {
            $html = <<<Eof
            <h1 class="page-title"> 
              请在语言包添加对应名称，路由不可使用闭包
            </h1>
Eof;
        }
        return $html;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2017/4/5 0005
 * Time: 17:07
 * @author DukeAnn
 */

namespace App\Presenters\Admin;

use Route;

class ArticleCategoriesPresenter
{
    /*
     * 文章分类列表
     * */
    public function cateOrderList($cates)
    {
        $html = '<ol class="dd-list">';
        foreach ($cates as $key => $cate) {
            $delete_url = route("article_categories.destroy", $cate->id);
            $edit_url = route("article_categories.edit", $cate->id);
            $name = htmlspecialchars($cate->name);
            $display_name = htmlspecialchars($cate->display_name);
            $html .= <<<Eof
                <li class="dd-item" id="menu_li_{$cate->id}" data-id="{$cate->id}">
                    <div class="dd-handle">
                        {$name}-别名:&nbsp;{$display_name}
                        <span class="menu-option action dd-nodrag" data-field-name="_edit">
                            <a href="javascript:;" data-href="{$edit_url}" class="editMenu"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);">
                                <i class="fa fa-trash mt-sweetalert"
                                   data-title="确定要删除此分类吗？"
                                   data-message="（子分类会也会被删除）"
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
                                   data-id={$cate->id}
                                >
                                </i>
                            </a>
                        </span>
                    </div>
Eof;
            if(!empty($cate->child)) {
                $html .= $this->cateOrderList($cate->child);
            }
            $html .= '</li>';
        }
        $html .= '</ol>';
        return $html;
    }
}
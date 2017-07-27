/**
 * cate 动态调用
 * Created by ADKi on 2017/4/5 0001.
 */
var menu = function () {

    var menu_select = {
        box:'.add_menu_html',
        createMenu:'.create_menu',
        close:'.close-link',
        createForm:'#createBox',
        middleBox:'.middle-box',
        createButton:'.createButton',
    };
    var menuInit = function () {
        $(menu_select.box).on('click', menu_select.createMenu, function () {
            $.ajax({
                type: 'GET',
                url:'/admin/article_categories/create',
                dataType:'html',
                success:function (htmlData) {
                    $(menu_select.middleBox).hide();
                    $(menu_select.box).append(htmlData);
                },
                error: function (xhr,errorText,errorType) {
                    var result =$.parseJSON(xhr.responseText);
                    if (result.error == "no_permissions") {
                        sweetAlert({
                            title:"您没有此权限",
                            text:"请联系管理员",
                            type:"error"
                        });
                        return false;
                    } else {
                        sweetAlert({
                            title:"未知错误",
                            text:"请联系管理员",
                            type:"error"
                        });
                        return false;
                    }
                }
            });
        });

        // 关闭表单
        $(menu_select.box).on('click', menu_select.close, function () {
            $('.formBox').remove();
            $(menu_select.middleBox).show();
        });

        // 提交创建菜单
        $(menu_select.box).on('click','.createButton',function () {
            var _item = $(this);
            var _form = $('#createForm');
            $.ajax({
                url:'/admin/article_categories',
                type:'post',
                dataType: 'json',
                data:_form.serializeArray(),
                headers : {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                beforeSend : function(){
                    _item.attr('disabled','true');
                },
                success:function (response) {
                    sweetAlert(response.message);
                    setTimeout(function(){
                        window.location.href = '/admin/article_categories';
                    }, 1000);
                }
            }).fail(function(response) {
                if(response.status == 422){
                    var data = $.parseJSON(response.responseText);
                    var layerStr = "";
                    for(var i in data){
                        layerStr += data[i]+" ";
                    }
                    sweetAlert('错误', layerStr);
                }
            }).always(function () {
                _item.removeAttr('disabled');
            });
        });

        /*
        * 修改表单
        * */
        $('#nestable_list_1').on('click', '.editMenu', function () {
            var _item = $(this);
            $.ajax({
                url:_item.attr('data-href'),
                dataType:'html',
                success:function (htmlData) {
                    var box = $(menu_select.middleBox);
                    if (box.is(':visible')) {
                        $(menu_select.middleBox).hide();
                    }else{
                        var _createForm = $('.formBox');
                        // 创建表单存在的情况下
                        if (_createForm.length > 0) {
                            _createForm.remove();
                        }
                    }
                    $(menu_select.box).append(htmlData);
                },
                error: function (xhr,errorText,errorType) {
                    var result =$.parseJSON(xhr.responseText);
                    if (result.error == "no_permissions") {
                        sweetAlert({
                            title:"您没有此权限",
                            text:"请联系管理员",
                            type:"error"
                        });
                        return false;
                    } else {
                        sweetAlert({
                            title:"未知错误",
                            text:"请联系管理员",
                            type:"error"
                        });
                        return false;
                    }
                }
            });
        });

        /*
        * 保存编辑
        * */
        $(menu_select.box).on('click','.editButton',function () {
            var _item = $(this);
            var _form = $('#editForm');

            $.ajax({
                url:_form.attr('action'),
                type:'post',
                dataType: 'json',
                data:_form.serializeArray(),
                headers : {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                beforeSend : function(){
                    _item.attr('disabled','true');
                },
                success:function (response) {
                    sweetAlert(response.message);
                    setTimeout(function(){
                        window.location.href = '/admin/article_categories';
                    }, 1000);
                }
            }).fail(function(response) {
                if(response.status == 422){
                    var data = $.parseJSON(response.responseText);
                    var layerStr = "";
                    for(var i in data){
                        layerStr += data[i]+" ";
                    }
                    sweetAlert('错误', layerStr);
                }
            }).always(function () {
                _item.removeAttr('disabled');
            });;
        });
    };

    return {
        init : menuInit
    }
}();

$(function () {
    menu.init();
});
/**
 * Created by ADKi on 2017/4/13 0013.
 */
var choose = function () {
    var id = $('#tag_id').val();
    if (!id) {
        saveTag();
    } else {
        updateTags(id)
    }
};
/*添加*/
var addTag = function () {
    $('#tag_id').val('');
    $('#tag_add').modal();
};
/*获取标签信息*/
var getTag = function (id) {
    $.ajax({
        url: '/admin/article_tag/' + id + '/edit',
        dataType: 'json',
        success: function (result) {
            if (result.code == 0) {
                $('#tag_name').val(result.data.tag.name);
                $('#tag_display_name').val(result.data.tag.display_name);
                $('#tag_id').val(result.data.tag.id);
                $('#tag_add').modal();
            } else {
                sweetAlert({
                    title:result.message,
                    text:"请联系管理员",
                    type:"error"
                });
            }
        },
        error: function (HttpRequest) {
            var error_json = HttpRequest.responseJSON;
            if (error_json.error == "no_permissions") {
                sweetAlert({
                    title:"您没有此权限",
                    text:"请联系管理员",
                    type:"error"
                });
            } else {
                sweetAlert({
                    title:"未知错误",
                    text:"请联系管理员",
                    type:"error"
                });
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
};

var saveTag = function () {
    var tag_name = $('#tag_name').val();
    var tag_display_name = $('#tag_display_name').val();
    $('#name_error').attr('class', '');
    $('#display_name_error').attr('class', '');
    var settings = {
        type: "POST",
        url: store_url,
        data: {name : tag_name, display_name: tag_display_name},
        dataType:"json",
        success: function(data) {
            if (data.code == 0) {
                $('#tag_add').modal('hide');
                swal(data.message, '点击按钮返回', 'success');
                $("#datatable_ajax").dataTable().fnClearTable();
            } else {
                $('#tag_add').modal('hide');
                swal(data.message, '点击按钮返回', 'error');
            }
            $('#tag_name').val('');
            $('#tag_display_name').val('');
            $('#tag_error').hide();
        },
        error: function (HttpRequest) {
            var error_json = HttpRequest.responseJSON;
            if (error_json.error == "no_permissions") {
                sweetAlert({
                    title:"您没有此权限",
                    text:"请联系管理员",
                    type:"error"
                });
            } else {
                var text = '';
                $('#tag_error').show();
                $.each(error_json, function (i, val) {
                    if (i == 'name') {
                        $('#name_error').addClass('has-error');
                    }
                    if (i == 'display_name') {
                        $('#display_name_error').addClass('has-error');
                    }
                    text += val;
                    $('#post-error').html(text);
                });
                return false;
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    $.ajax(settings);
};

var updateTags = function (id) {
    var tag_name = $('#tag_name').val();
    var tag_display_name = $('#tag_display_name').val();
    $('#name_error').attr('class', '');
    $('#display_name_error').attr('class', '');
    var settings = {
        type: "PUT",
        url: '/admin/article_tag/' + id,
        data: {name : tag_name, display_name: tag_display_name},
        dataType:"json",
        success: function(data) {
            if (data.code == 0) {
                $('#tag_add').modal('hide');
                swal(data.message, '点击按钮返回', 'success');
                $("#datatable_ajax").dataTable().fnClearTable();
            } else {
                $('#tag_add').modal('hide');
                swal(data.message, '点击按钮返回', 'error');
            }
            $('#tag_name').val('');
            $('#tag_display_name').val('');
            $('#tag_id').val('');
            $('#tag_error').hide();
        },
        error: function (HttpRequest) {
            var error_json = HttpRequest.responseJSON;
            if (error_json.error == "no_permissions") {
                sweetAlert({
                    title:"您没有此权限",
                    text:"请联系管理员",
                    type:"error"
                });
            } else {
                var text = '';
                $('#tag_error').show();
                $.each(error_json, function (i, val) {
                    if (i == 'name') {
                        $('#name_error').addClass('has-error');
                    }
                    if (i == 'display_name') {
                        $('#display_name_error').addClass('has-error');
                    }
                    text += val;
                    $('#post-error').html(text);
                });
                return false;
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    $.ajax(settings);
};
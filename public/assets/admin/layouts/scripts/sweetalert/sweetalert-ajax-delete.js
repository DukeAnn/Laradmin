/**
 * 美化弹窗js
 * 传入删除啊 url 和 删除的 dom id
 * Created by ADKi on 2016/12/21 0021.
 */
var SweetAlert = function () {
    return {
        //main function to initiate the module
        init: function () {
            $('.mt-sweetalert').each(function(){
                var sa_title = $(this).data('title');
                var sa_message = $(this).data('message');
                var sa_type = $(this).data('type');
                var sa_allowOutsideClick = $(this).data('allow-outside-click');
                var sa_showConfirmButton = $(this).data('show-confirm-button');
                var sa_showCancelButton = $(this).data('show-cancel-button');
                var sa_closeOnConfirm = $(this).data('close-on-confirm');
                var sa_closeOnCancel = $(this).data('close-on-cancel');
                var sa_confirmButtonText = $(this).data('confirm-button-text');
                var sa_cancelButtonText = $(this).data('cancel-button-text');
                var sa_popupTitleSuccess = $(this).data('popup-title-success');
                var sa_popupMessageSuccess = $(this).data('popup-message-success');
                var sa_popupTitleCancel = $(this).data('popup-title-cancel');
                var sa_popupMessageCancel = $(this).data('popup-message-cancel');
                var sa_confirmButtonClass = $(this).data('confirm-button-class');
                var sa_cancelButtonClass = $(this).data('cancel-button-class');
                var sa_showLoaderOnConfirm = $(this).data('show-loader-on-confirm');
                var ajax_url = $(this).data('ajax-url');
                var remove_dom = $(this).data('remove-dom');
                var id = $(this).data('id');
                $(this).click(function(){
                    swal({
                            title: sa_title,
                            text: sa_message,
                            type: sa_type,
                            allowOutsideClick: sa_allowOutsideClick,
                            showConfirmButton: sa_showConfirmButton,
                            showCancelButton: sa_showCancelButton,
                            confirmButtonClass: sa_confirmButtonClass,
                            cancelButtonClass: sa_cancelButtonClass,
                            closeOnConfirm: sa_closeOnConfirm,
                            closeOnCancel: sa_closeOnCancel,
                            confirmButtonText: sa_confirmButtonText,
                            cancelButtonText: sa_cancelButtonText,
                            showLoaderOnConfirm: sa_showLoaderOnConfirm,
                            popupMessageSuccess: sa_popupMessageSuccess,
                            popupTitleCancel: sa_popupTitleCancel,
                            popupMessageCancel: sa_popupMessageCancel
                        },
                        function () {
                            setTimeout(function () {
                                var settings = {
                                    type: "DELETE",
                                    url: ajax_url,
                                    dataType:"json",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        $("#" + remove_dom + id).remove();
                                        swal(sa_popupTitleSuccess, "点击按钮返回", "success");
                                    },
                                    error:function (xhr, errorText, errorType) {
                                        if (xhr.responseJSON.error == 'no_permissions') {
                                            sweetAlert({
                                                title:'您没有此权限',
                                                text:"请联系管理员",
                                                type:"error"
                                            });
                                            return false;
                                        } else {
                                            sweetAlert({
                                                title: '错误：' + xhr.responseJSON.error,
                                                text:"请联系管理员",
                                                type:"error"
                                            });
                                            return false;
                                        }
                                    }
                                };
                                $.ajax(settings);
                            }, 500);
                        });
                });
            });

        }
    }

}();
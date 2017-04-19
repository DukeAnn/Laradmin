@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
    <style type="text/css">
        .dataTables_info {
            padding-top: 8px;
            white-space: nowrap;
        }
        .dataTables_paginate {
            margin: 0;
            white-space: nowrap;
            text-align: right;
        }
    </style>
@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">系统日志列表</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                            <tr>
                                @foreach($headers as $key => $header)
                                    <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                        @if ($key == 'date')
                                            <span class="label label-sm label-info">{{ $header }}</span>
                                        @else
                                            <span class="level {{ log_styler()->color($key) }} dashboard-stat bg-font-dark">
                                                {!! log_styler()->icon($key) . ' ' . $header !!}
                                            </span>
                                        @endif
                                    </th>
                                @endforeach
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($rows->count() > 0)
                                @foreach($rows as $date => $row)
                                    <tr id="log_li_{{ $date}}">
                                        @foreach($row as $key => $value)
                                            <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                                @if ($key == 'date')
                                                    <span class="label label-primary">{{ $value }}</span>
                                                @elseif ($value == 0)
                                                    <span class="level level-empty">{{ $value }}</span>
                                                @else
                                                    <a href="{{ route('log.filter', [$date, $key]) }}">
                                                        <span class="level level-{{ $key }}">{{ $value }}</span>
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="text-center">
                                            <a href="{{ route('log.show', [$date]) }}" class="btn blue btn-xs btn-outline">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <a href="{{ route('log.download', [$date]) }}" class="btn green btn-xs btn-outline">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="javascript:;" class="btn red btn-xs btn-outline mt-sweetalert"
                                               style="margin-bottom: 0;"
                                               data-title="确定要删除{{ $date }}日志吗？"
                                               data-message="（该日志文件将会被删除）"
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
                                               data-ajax-url="{{ route('log.destroy') }}"
                                               data-remove-dom="log_li_"
                                               data-date-json="{{ json_encode(['date' => $date]) }}"
                                               data-date="{{ $date }}"
                                            >
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center">
                                        <span class="label label-default">{{ trans('log-viewer::general.empty-logs') }}</span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" id="sample_editable_1_info" role="status" aria-live="polite">
                                当前第 {{ $rows->currentPage() }} 页，共 {{ $rows->total() }} 条日志
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                {!! $rows->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
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
                    var date_json = $(this).data('date-json');
                    var date = $(this).data('date');
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
                                        data: date_json,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function(data) {
                                            if (data.result == 'error') {
                                                sweetAlert({
                                                    title:"删除失败",
                                                    text:"请联系管理员",
                                                    type:"error"
                                                });
                                            } else {
                                                $("#" + remove_dom + date).remove();
                                                swal(sa_popupTitleSuccess);
                                            }
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
                                                    title:'未知错误',
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
    /*alert()弹窗*/
    jQuery(document).ready(function() {
        SweetAlert.init();
    });
</script>
@endsection


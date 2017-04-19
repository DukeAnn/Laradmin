@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
<link href="{{asset('assets/admin/layouts/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('log-viewer::_partials.menu')
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-red"></i>
                            <span class="caption-subject font-red sbold uppercase">日志信息</span>
                        </div>
                        <div class="actions">
                            <a href="{{ route('log.download', [$log->date]) }}" class="btn btn-transparent green btn-outline btn-circle btn-sm">
                                <i class="fa fa-download"></i>下载
                            </a>
                            <a href="javascript:;" class="btn btn-transparent red btn-outline btn-circle btn-sm mt-sweetalert"
                               style="margin-bottom: 0;"
                               data-title="确定要删除{{ $log->date }}日志吗？"
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
                               data-date-json="{{ json_encode(['date' => $log->date]) }}"
                               data-date="{{ $log->date }}"
                            >
                                <i class="fa fa-trash-o"></i>删除
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr>
                                    <th>文件路径 :</th>
                                    <th colspan="5">{{ $log->getPath() }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>日志总数：</td>
                                    <td>
                                        <span class="label label-sm label-success">{{ $entries->total() }}</span>
                                    </td>
                                    <td>大小：</td>
                                    <td>
                                        <span class="label label-sm label-success">{{ $log->size() }}</span>
                                    </td>
                                    <td>创建时间：</td>
                                    <td>
                                        <span class="label label-sm label-success">{{ $log->createdAt() }}</span>
                                    </td>
                                    <td>更新时间：</td>
                                    <td>
                                        <span class="label label-sm label-success">{{ $log->updatedAt() }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">详细信息列表</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @if ($entries->hasPages())
                        <div class="panel-footer">
                            {!! $entries->render() !!}

                            <span class="label label-info pull-right">
                            当前第 {!! $entries->currentPage() !!} 页，总共 {!! $entries->lastPage() !!} 页
                        </span>
                        </div>
                    @endif
                    <div class="mt-element-list">
                        <div class="mt-list-container list-simple ext-1 group">
                            <table class="table table-hover table-light">
                                <thead>
                                <tr>
                                    <th>ENV</th>
                                    <th style="width: 120px;">日志级别</th>
                                    <th style="width: 65px;">时间</th>
                                    <th>错误头</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($entries as $key => $entry)
                                    <tr>
                                        <td>
                                            <span class="label label-sm label-warning">{{ $entry->env }}</span>
                                        </td>
                                        <td>
                                        <span class="level {{ log_styler()->color($entry->level) }} dashboard-stat bg-font-dark">
                                            {!! $entry->level() !!}
                                        </span>
                                        </td>
                                        <td>
                                        <span class="label label-default">
                                            {{ $entry->datetime->format('H:i:s') }}
                                        </span>
                                        </td>
                                        <td>
                                            <p>{{ $entry->header }}</p>
                                        </td>
                                        <td class="text-right">
                                            @if ($entry->hasStack())
                                                <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" href="#log-stack-{{ $key }}" aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                                    <i class="fa fa-toggle-on"></i> 查看
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($entry->hasStack())
                                        <tr>
                                            <td colspan="5" class="stack">
                                                <div class="stack-content collapse" id="log-stack-{{ $key }}">
                                                    {!! $entry->stack() !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($entries->hasPages())
                        <div class="panel-footer">
                            {!! $entries->render() !!}

                            <span class="label label-info pull-right">
                            当前第 {!! $entries->currentPage() !!} 页，总共 {!! $entries->lastPage() !!} 页
                        </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
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
                                                swal({
                                                    title: sa_popupTitleSuccess,
                                                    text: "点击返回列表",
                                                    type: "success",
                                                    showCancelButton: false
                                                },
                                                function(){
                                                    setTimeout(function(){
                                                        window.location.href='{{ route('log.list') }}';
                                                    }, 50);
                                                });
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
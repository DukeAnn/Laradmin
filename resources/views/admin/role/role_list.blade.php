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
                        <span class="caption-subject font-red sbold uppercase">用户角色管理</span>
                    </div>
                    <div class="actions">
                        <a href="{{ url('admin/role/create') }}" class="btn green btn-outline">
                            <i class="fa fa-edit"></i>
                            添加角色
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> 角色标识 </th>
                                    <th> 角色介绍 </th>
                                    <th> 角色名 </th>
                                    <th> 添加时间 </th>
                                    <th> 修改时间 </th>
                                    <th> 操作 </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr id="role_li_{{ $role->id }}">
                                    <td> {{ $role->id }} </td>
                                    <td> {{ $role->name }} </td>
                                    <td> {{ $role->description }} </td>
                                    <td>
                                        <span class="label label-sm label-success"> {{ $role->display_name }} </span>
                                    </td>
                                    <td> {{ $role->created_at }} </td>
                                    <td> {{ $role->updated_at }} </td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-outline btn-circle dark btn-sm black mt-sweetalert"
                                           style="margin-bottom: 0;"
                                           data-title="确定要删除该用户组吗？"
                                           data-message="（该用户组下的用户将会被解绑）"
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
                                           data-ajax-url="{{ route('role.destroy', $role->id) }}"
                                           data-remove-dom="role_li_"
                                           data-id="{{ $role->id }}"
                                        >
                                            <i class="fa fa-trash-o"></i>
                                            删除
                                        </a>
                                        <a href="{{ url("admin/role/$role->id/edit") }}" class="btn btn-outline btn-circle green btn-sm purple">
                                            <i class="fa fa-edit"></i>
                                            编辑
                                        </a>
                                        <a href="javascript:;" onclick="getRoleInfo({{ $role->id }})" class="btn blue mt-ladda-btn ladda-button btn-circle btn-outline">
                                            <i class="fa fa-eye"></i>
                                            查看
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" id="sample_editable_1_info" role="status" aria-live="polite">
                                当前第 {{ $roles->currentPage() }} 页，共 {{ $roles->total() }} 个用户角色
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div class="modal fade draggable-modal" id="role_info" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">角色名</h4>
                </div>
                <div class="modal-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <tbody>
                            <tr>
                                <td class="text-right col-sm-3"><strong> 角色名 </strong></td>
                                <td class="col-sm-8" id="role_display_name">  </td>
                            </tr>
                            <tr>
                                <td class="text-right col-sm-3"><strong> 角色标识 </strong></td>
                                <td class="col-sm-8" id="role_name">  </td>
                            </tr>
                            <tr>
                                <td class="text-right col-sm-3"><strong> 角色描述 </strong></td>
                                <td class="col-sm-8" id="role_description">  </td>
                            </tr>
                            <tr>
                                <td class="text-right col-sm-3"><strong> 添加时间 </strong></td>
                                <td class="col-sm-8" id="role_created_at">  </td>
                            </tr>
                            <tr>
                                <td class="text-right col-sm-3"><strong> 修改时间 </strong></td>
                                <td class="col-sm-8" id="role_updated_at">  </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                            <tr>
                                <th class="col-sm-2 text-center"> 模块 </th>
                                <th class="col-sm-9 text-center"> 权限 </th>
                            </tr>
                            </thead>
                            <tbody id="role_perms">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">关闭</button>
                    <a type="button" class="btn green" id="role_edit" href="">编辑</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
{{--sweetalert弹窗--}}
<script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var delete_url = "{{ url("admin/role") }}";
    var info_url = "{{ url("admin/role") }}";
    /*alert()弹窗*/
    jQuery(document).ready(function() {
        SweetAlert.init();
    });

    function getRoleInfo(id) {
        var edit_url = info_url+'/'+id+'/edit';
        var html = '';
        var settings = {
            type: "GET",
            url: info_url+'/'+id,
            dataType:"json",
            success: function(data) {
                var perms = data.perms;
                var role = data.role;
                $('.modal-title').text(role.display_name);
                $('#role_display_name').text(role.display_name);
                $('#role_name').text(role.name);
                $('#role_description').text(role.description);
                $('#role_created_at').text(role.created_at);
                $('#role_updated_at').text(role.updated_at);
                $.each(perms, function (index_1, perm_group) {
                    html += '<tr><td class="text-center"><strong> '+ index_1 +' </strong></td><td>';
                    $.each(perm_group, function (index_2, perm) {
                        html += '<div class="col-md-4">'+
                                        perm.display_name+
                                '</div>';
                    });
                    html += '</td></tr>';
                });
                $('#role_perms').text('');
                $('#role_perms').append(html);
                $('#role_edit').attr('href', edit_url);
                $('#role_info').modal();
            },
            error: function (HttpRequest) {
                if (HttpRequest.responseJSON.error == "no_permissions") {
                    sweetAlert({
                        title:"您没有此权限",
                        text:"请联系管理员",
                        type:"error"
                    });
                }
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        };
        $.ajax(settings);
    }

</script>
@endsection


@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
    <link href="{{ asset('vendor/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    {{--ajax使用--}}
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">用户权限管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a href="{{ route('permissions.create') }}" class="btn green btn-outline">
                                <i class="fa fa-edit"></i>
                                添加权限
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                            <thead>
                            <tr role="row" class="heading">
                                <th > ID </th>
                                <th > 权限标识 </th>
                                <th > 绑定路由名 </th>
                                <th > 权限名 </th>
                                <th > 添加时间 </th>
                                <th > 修改时间 </th>
                                <th > 操作 </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
<script type="text/javascript">
    var ajax_url = "{{ route('permissions.getPermissions') }}";
</script>
<script src="{{asset('assets/admin/layouts/scripts/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
{{--ajax使用--}}
<script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
{{--datatables操作插件--}}
<script src="{{asset('assets/admin/permission/scripts/datatables-permissions.js')}}" type="text/javascript"></script>
{{--sweetalert弹窗--}}
<script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>
@endsection


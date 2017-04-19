@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">用户管理</span>
                    </div>
                   {{-- <div class="actions">
                        <div class="btn-group">
                            <a href="{{ route('user.create') }}" class="btn green btn-outline">
                                <i class="fa fa-edit"></i>
                                添加权限
                            </a>
                        </div>
                    </div>--}}
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                            <thead>
                            <tr role="row" class="heading">
                                <th > ID </th>
                                <th > 用户名 </th>
                                <th > 邮箱 </th>
                                <th > 角色 </th>
                                <th > 注册时间 </th>
                                <th > 最后登录 </th>
                                <th > 操作 </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
<script type="text/javascript">
    var ajax_url = "{{ route('user.getUsers') }}";
</script>
<script src="{{asset('assets/admin/layouts/scripts/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
{{--ajax使用--}}
<script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
{{--datatables操作插件--}}
<script src="{{asset('assets/admin/user/scripts/datatables-users.js')}}" type="text/javascript"></script>
{{--sweetalert弹窗--}}
<script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>

@endsection


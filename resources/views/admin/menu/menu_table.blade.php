@extends('admin.layouts.main')
@inject('MenuPresenter', 'App\Presenters\Admin\MenuPresenter')
{{--顶部前端资源--}}
@section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('assets/admin/menu/plugins/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/menu/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <style type="text/css">
        .menu-option {
            float: right;
        }
        .menu-option i {
            margin: 0px 5px;
        }
    </style>
@endsection

{{--页面内容--}}
@section('content')
    <div class="note note-success">
        <span class="label label-danger">警告!</span>
        <span class="bold"> 请填写存在的路由名称 </span>
        如果填写了不存在的路由名称，程序将崩溃报错！小心填写，报错要执行 <code>php artisan cache:clear</code> 清除缓存，并删除数据库中插入的错误数据！
    </div>
    <div class="row">
        <input type="hidden" id="nestable_list_1_output">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">菜单列表</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn blue-haze btn-outline btn-circle btn-sm" href="{{ route('menutable.create') }}" style="margin-right: 15px">添加菜单</a>
                        <button type="button" class="btn purple mt-ladda-btn ladda-button btn-outline btn-circle" data-style="slide-left" data-spinner-color="#333" id="menu-save">
                            <span class="ladda-label">保存排序</span>
                            <span class="ladda-spinner"></span>
                        </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body ">
                    <div class="dd" id="nestable_list_1">
                        @if(!empty($menus))
                            {!! $MenuPresenter->menuOrderList($menus) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('assets/admin/menu/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/menu/scripts/ui-nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/menu/plugins/ladda/spin.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/menu/plugins/ladda/ladda.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/menu/scripts/ui-buttons.min.js') }}" type="text/javascript"></script>
{{--sweetalert弹窗--}}
<script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        SweetAlert.init();
    });
    var cache_url = "{{ route('menutable.saveMenuOrder') }}";
    //保存排序
    $('#menu-save').on('click' ,function () {
        var menu = $('#nestable_list_1_output').val();
        var settings = {
            type: "POST",
            url: cache_url,
            data: {menu: menu},
            dataType:"json",
            success: function(data) {
                if (data.error == "no_permissions") {
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
        $.ajax(settings)
    });
</script>
@endsection
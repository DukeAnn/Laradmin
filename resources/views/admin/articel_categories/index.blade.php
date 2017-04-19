@extends('admin.layouts.main')
@inject('ArticleCategories', 'App\Presenters\Admin\ArticleCategoriesPresenter')
{{--顶部前端资源--}}
@section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('vendor/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
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
    <div class="row">
        <input type="hidden" id="nestable_list_1_output">
        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-list font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">分类列表</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <button type="button" class="btn purple mt-ladda-btn ladda-button btn-outline btn-circle" data-style="slide-left" data-spinner-color="#333" id="menu-save">
                                <span class="ladda-label">保存排序</span>
                                <span class="ladda-spinner"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body ">
                    <div class="dd" id="nestable_list_1">
                        @if(!empty($cate_list))
                            {!! $ArticleCategories->cateOrderList($cate_list) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 add_menu_html">
            <div class="text-center middle-box" style="margin-top: 150px">
                <h4 style="color: #555"> 在这里添加或者编辑分类内容 </h4>
                <button type="button" class="btn btn-success mt-ladda-btn ladda-button create_menu" data-style="expand-up">
                    <span class="ladda-label">
                        <i class="fa fa-plus"></i> 添加分类
                    </span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('vendor/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/article_categories/scripts/ui-nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/ladda/spin.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/ladda/ladda.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/article_categories/scripts/ui-buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/article_categories/scripts/categories.js') }}" type="text/javascript"></script>
    {{--sweetalert弹窗--}}
    <script src="{{ asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script type="text/javascript">
        jQuery(document).ready(function() {
            SweetAlert.init();
        });
        var cache_url = "{{ route('article_categories.saveCateOrder') }}";
        //保存排序
        $('#menu-save').on('click' ,function () {
            var cate = $('#nestable_list_1_output').val();
            var settings = {
                type: "POST",
                url: cache_url,
                data: {cate: cate},
                dataType:"json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    sweetAlert({
                        title:"保存成功",
                        type:"success"
                    });
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
            $.ajax(settings)
        });
    </script>
@endsection
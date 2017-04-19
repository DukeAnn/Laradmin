@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
    <link href="{{ asset('vendor/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    {{--ajax使用--}}
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /*.p-margin-top p{ margin: 10px 0px 10px 0px; }*/
    </style>
@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">标签列表</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a href='javascript:;' class="btn green btn-outline" onclick="addTag()">
                                <i class="fa fa-edit"></i>
                                添加标签
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
                                <th > 标签名称 </th>
                                <th > 标签别名 </th>
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
    {{-- 添加标签 --}}
    <div id="tag_add" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">添加标签</h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible1="1">
                        <div class="col-md-12">
                            <input type="hidden" id="tag_id" name="tag_id">
                            <div class="" id="name_error">
                                <p>
                                    <input class="form-control" type="text" id="tag_name" placeholder="标签名">
                                </p>
                            </div>
                            <div class="" id="display_name_error">
                                <p>
                                    <input class="form-control" type="text" id="tag_display_name" placeholder="英文别名(只能是字母)">
                                </p>
                            </div>
                            <p class="alert alert-danger" style="display: none" id="tag_error">
                                <strong>错误!</strong>&nbsp;&nbsp;<span id="post-error"></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                    <button type="button" class="btn green" href="javascript:;" onclick="choose()">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
    <script type="text/javascript">
        var ajax_url = "{{ route('article_tag.getTags') }}";
        var store_url = "{{ route("article_tag.store") }}";
    </script>
    <script src="{{asset('assets/admin/layouts/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    {{--ajax使用--}}
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    {{--datatables操作插件--}}
    <script src="{{asset('assets/admin/article_tags/scripts/datatables-tags.js')}}" type="text/javascript"></script>
    {{--sweetalert弹窗--}}
    <script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/article_tags/scripts/article-tags.js')}}" type="text/javascript"></script>
@endsection


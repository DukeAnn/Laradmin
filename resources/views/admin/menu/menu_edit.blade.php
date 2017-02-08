@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <i class="icon-pin font-green"></i>
                        <span class="caption-subject bold uppercase">编辑菜单</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>信息填写出错!</strong>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif
                    <form role="form" method="post" action="{{ route("menutable.update", $menu_info->id) }}" id="form_menu">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $menu_info->id }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label has-success">
                                        <input type="text" class="form-control" disabled="" id="form_control_1" value="{{ $menu_info->created_at }}">
                                        <label for="form_control_1">创建时间</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label has-warning">
                                        <input type="text" class="form-control" disabled="" id="form_control_1" value="{{ $menu_info->updated_at }}">
                                        <label for="form_control_1">更新时间</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label
                            <?php if ($errors->has('name')) { echo "has-error"; } ?>">
                                <input type="text" class="form-control" id="form_name" name="name" value="{{ $menu_info->name }}">
                                <label for="form_name">名称</label>
                                <span class="help-block">菜单名称</span>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label
                            <?php if ($errors->has('icon')) { echo "has-error"; } ?>">
                                <input type="text" class="form-control" id="form_icon" name="icon" value="{{ $menu_info->icon }}">
                                <label for="form_icon">图标</label>
                                <span class="help-block">Simple Line Icons字体图标代码(icon-后面的内容)</span>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label
                            <?php if ($errors->has('uri')) { echo "has-error"; } ?>">
                                <input type="text" class="form-control" id="form_uri" name="uri" value="{{ $menu_info->uri }}">
                                <label for="form_uri">路径名称</label>
                                <span class="help-block">路由文件中设置的路由名称</span>
                            </div>
                        </div>
                        <div class="form-actions noborder">
                            <button type="submit" class="btn blue" >更新菜单</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
    {{--清空表单--}}
   {{-- <script type="text/javascript">
        $(function() {
            $("#form_rewrite").click(function() {
                $("#form_menu :input").not(":button, :submit, :reset, :hidden").val("").removeAttr("checked").remove("selected");//核心
            });
        })
    </script>--}}
@endsection
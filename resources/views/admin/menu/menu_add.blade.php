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
                        <span class="caption-subject bold uppercase">添加菜单</span>
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
                    <form role="form" method="post" action="{{ route('menutable.store') }}">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label ">
                                        <select class="form-control edited " id="form_parent_menu_1" name="parent_id_1">
                                            <option value="0" selected>无一级菜单</option>
                                            @if(!empty($menu_first))
                                                @foreach($menu_first as $menu)
                                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label for="form_parent_menu_1">一级菜单</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input form-md-floating-label ">
                                        <select class="form-control edited " id="form_parent_menu_2" name="parent_id_2">
                                            <option value="0" selected>无二级菜单</option>
                                        </select>
                                        <label for="form_parent_menu_1">二级菜单</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label
                            <?php if ($errors->has('name')) { echo "has-error"; } ?>">
                                <input type="text" class="form-control" id="form_name" name="name" value="{{ old('name') }}">
                                <label for="form_name">名称</label>
                                <span class="help-block">菜单名称</span>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label
                            <?php if ($errors->has('icon')) { echo "has-error"; } ?>">
                                <input type="text" class="form-control" id="form_icon" name="icon" value="{{ old('icon') }}">
                                <label for="form_icon">图标</label>
                                <span class="help-block">Simple Line Icons字体图标代码(icon-后面的内容)</span>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label
                            <?php if ($errors->has('uri')) { echo "has-error"; } ?>">
                                <input type="text" class="form-control" id="form_uri" name="uri" value="{{ old('uri') }}">
                                <label for="form_uri">路径名称</label>
                                <span class="help-block">路由文件中设置的路由名称</span>
                            </div>
                        </div>
                        <div class="form-actions noborder">
                            <button type="submit" class="btn blue" >创建菜单</button>
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
<script type="text/javascript">
    $('#form_parent_menu_1').change(function () {
        var id = $('#form_parent_menu_1').val();
        var url = "{{ route('menutable.ajaxGetChild') }}";
        //先清空下拉列表
        $('#form_parent_menu_2').empty();
        $('#form_parent_menu_2').append("<option value='0' selected>无二级菜单</option>");
        //重新获取下拉列表
        $.getJSON(
                url,
                {parent_id:id},
                function (data) {
                    if (data != []) {
                        var html = '';
                        $(data).each(function (index, element) {
                            html += "<option value='"+element.id+"'>"+element.name+"</option>"
                        });
                        $('#form_parent_menu_2').append(html);
                    }

                }
        );

    });
</script>
@endsection

<div class="portlet light bordered formBox" id="editBox">
    <div class="portlet-title">
        <div class="caption font-green">
            <i class="icon-pin font-green"></i>
            <span class="caption-subject bold uppercase">编辑菜单</span>
        </div>
        <div class="actions">
            <a class="btn btn-circle btn-icon-only btn-default close-link">
                <i class="fa fa-times"></i>
            </a>
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
        <form role="form" method="post" action="{{ route("menutable.update", $menu_info->id) }}" id="editForm">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $menu_info->id }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input has-success">
                            <input type="text" class="form-control" disabled="" id="form_control_1" value="{{ $menu_info->created_at }}">
                            <label for="form_control_1">创建时间</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-md-line-input has-warning">
                            <input type="text" class="form-control" disabled="" id="form_control_1" value="{{ $menu_info->updated_at }}">
                            <label for="form_control_1">更新时间</label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-md-line-input
                <?php if ($errors->has('name')) { echo "has-error"; } ?>">
                    <input type="text" class="form-control" id="form_name" name="name" value="{{ $menu_info->name }}">
                    <label for="form_name">名称</label>
                    <span class="help-block">菜单名称</span>
                </div>
                <div class="form-group form-md-line-input
                <?php if ($errors->has('icon')) { echo "has-error"; } ?>">
                    <input type="text" class="form-control" id="form_icon" name="icon" value="{{ $menu_info->icon }}">
                    <label for="form_icon">图标</label>
                    <span class="help-block">字体图标代码(完整class名称支持 Fontawesome Icons，Simple Line Icons，Glyphicons)</span>
                </div>
                <div class="form-group form-md-line-input
                <?php if ($errors->has('uri')) { echo "has-error"; } ?>">
                    <input type="text" class="form-control" id="form_uri" name="uri" value="{{ $menu_info->uri }}">
                    <label for="form_uri">路径名称</label>
                    <span class="help-block">路由文件中设置的路由名称</span>
                </div>
            </div>
            <div class="form-actions noborder">
                <button type="submit" class="btn blue editButton" >更新菜单</button>
            </div>
        </form>
    </div>
</div>

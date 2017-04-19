
<div class="portlet light bordered formBox" id="createBox">
    <div class="portlet-title">
        <div class="caption font-green">
            <i class="icon-pin font-green"></i>
            <span class="caption-subject bold uppercase">添加分类</span>
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
        <form role="form" id="createForm">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group form-md-line-input form-md-floating-label ">
                    <select class="form-control edited " id="form_parent_menu_1" name="parent_id">
                        <option value="0" selected>顶级分类</option>
                        @if(!empty($cate_first))
                            @foreach($cate_first as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <label for="form_parent_menu_1">一级分类</label>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label
                <?php if ($errors->has('name')) { echo "has-error"; } ?>">
                    <input type="text" class="form-control" id="form_name" name="name" value="{{ old('name') }}">
                    <label for="form_name">名称</label>
                    <span class="help-block">分类名称</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <textarea type="text" class="form-control" id="form_describe" name="describe" rows="3">{{ old('icon') }}</textarea>
                    <label for="form_describe">描述</label>
                    <span class="help-block">分类描述信息，SEO描述</span>
                </div>
                <div class="form-group form-md-line-input form-md-floating-label">
                    <input type="text" class="form-control" id="form_display_name" name="display_name" value="{{ old('uri') }}">
                    <label for="form_display_name">分类英文别名</label>
                    <span class="help-block">链接地址显示名称</span>
                </div>
            </div>
            <div class="form-actions noborder">
                <button type="submit" class="btn green createButton" >创建分类</button>
            </div>
        </form>
    </div>
</div>

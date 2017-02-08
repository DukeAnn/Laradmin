@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">添加权限</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="{{ url('admin/permissions') }}" class="form-horizontal" method="post">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group form-md-line-input @if($errors->has('name')) has-error @endif">
                                <label class="col-md-3 control-label" for="name">权限标识</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="" name="name" id="name" value="{{ old('name') }}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('name') ? $errors->first('name') : '权限的唯一英文标识，格式（组名.权限名)' }}</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input @if($errors->has('display_name')) has-error @endif">
                                <label class="col-md-3 control-label" for="display_name">权限名</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="" name="display_name" id="display_name"  value="{{ old('display_name') }}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('display_name') ? $errors->first('display_name') : '用于权限的显示，标识的别名' }}</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input @if($errors->has('description')) has-error @endif">
                                <label class="col-md-3 control-label" for="description">权限描述</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" id="description" rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 100px;"> {{ old('description') }}</textarea>
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('description') ? $errors->first('description') : '权限的功能介绍信息' }}</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input @if($errors->has('uri')) has-error @endif">
                                <label class="col-md-3 control-label" for="display_name">绑定路由名</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="" name="uri" id="uri" value="{{ old('display_name') }}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('uri') ? $errors->first('uri') : '该权限对应的路由名' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="submit" class="btn green" value="添加权限">
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')

@endsection
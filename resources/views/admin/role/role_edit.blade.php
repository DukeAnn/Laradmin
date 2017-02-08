@extends('admin.layouts.main')
@inject('rolePermissions', 'App\Presenters\Admin\rolePermissionsPresenter')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">编辑用户组</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="{{ url("admin/role/$role->id") }}" class="form-horizontal" method="post" >
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $role->id }}">
                        <div class="form-body">
                            <div class="form-group form-md-line-input @if($errors->has('name')) has-error @endif">
                                <label class="col-md-3 control-label" for="name">角色标识</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="name" id="name" value="{{ $role->name }}"  readonly="readonly">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('name') ? $errors->first('name') : '角色的唯一英文标识' }}</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input @if($errors->has('display_name')) has-error @endif">
                                <label class="col-md-3 control-label" for="display_name">角色名</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="display_name" id="display_name" value="{{ $role->display_name }}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('display_name') ? $errors->first('display_name') : '用于角色的显示，标识的别名' }}</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input @if($errors->has('description')) has-error @endif">
                                <label class="col-md-3 control-label" for="description">角色描述</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="description" id="description" rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 100px;">{{ $role->description }}</textarea>
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{ $errors->has('description') ? $errors->first('description') : '角色的功能介绍信息' }}</span>
                                </div>
                            </div>
                            <div class="form-group form-md-checkboxes">
                                <div class="col-md-offset-1 col-md-10">
                                    @if(!empty($permissions))
                                    <div class="portlet light portlet-fit bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-settings font-red"></i>
                                                <span class="caption-subject font-red sbold uppercase">用户组权限</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-scrollable table-scrollable-borderless">
                                                <table class="table table-hover table-light">
                                                    <thead>
                                                    <tr class="uppercase">
                                                        <th class="col-md-1 text-center"> 模块 </th>
                                                        <th class="col-md-11 text-center"> 权限 </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    {!! $rolePermissions->getPermissions($permissions, $role->perms) !!}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-7">
                                    <input type="submit" class="btn green" value="更新角色">
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')

@endsection
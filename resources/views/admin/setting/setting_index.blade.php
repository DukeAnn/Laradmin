@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
    <link href="{{ asset('vendor/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bootstrap-editable/inputs-ext/address/address.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{--页面内容--}}
@section('content')
    <div class="m-heading-1 border-green m-bordered">
        <h3>提示</h3>
        <p> 自动保存 </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mt-checkbox-inline">
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" id="autoopen">&nbsp;自动切换到下一个
                    <span></span>
                </label>
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" id="inline">&nbsp;行内编辑
                    <span></span>
                </label>
                <button id="enable" class="btn green">编辑 / 查看</button>
            </div>
        </div>
    </div>
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-settings font-dark"></i>
                <span class="caption-subject font-dark sbold uppercase">系统设置选项</span>
            </div>
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">

                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    @if($set_all->count() > 0)
                        <table id="user" class="table table-bordered table-striped">
                        <tbody>
                        @foreach($set_all as $value)
                            <tr>
                                <td style="width:25%"> {{ $value['name'] }} </td>
                                <td style="width:20%">
                                    <a href="javascript:;"
                                       id="{{ $value['code'] }}"
                                       data-type="{{ $value['type'] }}"
                                       data-pk="{{ $value['id'] }}"
                                       data-original-title="{{ $value['describe'] }}"
                                       data-url="{{ route('setting.update', [$value['id']]) }}"
                                       data-name="value"
                                    >
                                        {{ $value['value'] }}
                                    </a>
                                </td>
                                <td style="width:55%">
                                    <span class="text-muted"> {{ $value['code'] }} </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="m-heading-1 border-green m-bordered">
                            <h3>无设置项</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
    {{-- 行内编辑脚本 --}}
    @include('admin.picture.script')

    <script src="{{ asset('vendor/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery.mockjax.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-editable/inputs-ext/address/address.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-typeahead/bootstrap3-typeahead.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/setting/scripts/form-editable.js') }}" type="text/javascript"></script>
@endsection
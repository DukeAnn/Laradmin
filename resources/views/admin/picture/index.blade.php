@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
    <link href="{{ asset('vendor/cubeportfolio/css/cubeportfolio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/picture/css/portfolio.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/jquery-file-upload/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/jquery-file-upload/css/jquery.fileupload-ui.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-heading-1 border-green m-bordered">
                <h3>选择上传的图片</h3>
                <p> 文件上传，可批量上传 </p>
            </div>
            <form id="fileupload" action="{{ route('picture.upload') }}" method="POST" enctype="multipart/form-data">
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span> 添加文件... </span>
                                                <input type="file" name="files[]" multiple=""> </span>
                        <button type="submit" class="btn blue start">
                            <i class="fa fa-upload"></i>
                            <span> 开始上传 </span>
                        </button>
                        <button type="reset" class="btn warning cancel">
                            <i class="fa fa-ban-circle"></i>
                            <span> 取消上传 </span>
                        </button>
                        <button type="button" class="btn red delete">
                            <i class="fa fa-trash"></i>
                            <span> 删除 </span>
                        </button>
                        <input type="checkbox" class="toggle">
                        <!-- The global file processing state -->
                        <span class="fileupload-process"> </span>
                    </div>
                    <!-- The global progress information -->
                    <div class="col-lg-5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width:0%;"> </div>
                        </div>
                        <!-- The extended global progress information -->
                        <div class="progress-extended"> &nbsp; </div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped clearfix">
                    <tbody class="files"> </tbody>
                </table>
            </form>
        </div>
    </div>
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"> </div>
        <h3 class="title"></h3>
        <a class="prev"> ‹ </a>
        <a class="next"> › </a>
        <a class="close white"> </a>
        <a class="play-pause"> </a>
        <ol class="indicator"> </ol>
    </div>

    <div class="portfolio-content portfolio-1">
        @if($images->total() > 0)
        <div id="js-filters-juicy-projects" class="cbp-l-filters-button">
            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase" style="overflow: visible"> 全部
                <div class="cbp-filter-counter"></div>
            </div>
            @foreach($year_months as $year_month)
                <div data-filter=".{{ $year_month['year_month'] }}" class="cbp-filter-item btn dark btn-outline uppercase" style="overflow: visible"> {{ $year_month['year_month'] }}
                    <div class="cbp-filter-counter"></div>
                </div>
            @endforeach
        </div>
        <div id="js-grid-juicy-projects" class="cbp">
                @foreach($images as $image)
                    <div class="cbp-item {{ $image->year_month }}" id="image_li_{{ $image->id }}">
                        <div class="cbp-caption">
                            <div class="cbp-caption-defaultWrap">
                                <img src="{{ Storage::url(dirname($image->path).'/'.$image->name.'_small.'.$image->extension) }}" alt=""> </div>
                            <div class="cbp-caption-activeWrap">
                                <div class="cbp-l-caption-alignCenter">
                                    <div class="cbp-l-caption-body">
                                        <a class="btn blue uppercase btn blue uppercase sbold" href="javascript:;" onclick="getId({{ $image->id }})">
                                            <i class="fa fa-edit"></i>编辑
                                        </a>

                                        <a href="{{ Storage::url($image->path) }}"
                                           class="cbp-lightbox btn green uppercase btn green uppercase" data-title="日期：{{ $image->created_at }}，占用空间：{{ human_filesize($image->size) }}<br>by 用户：{{ $image->user_name }}，ID：{{ $image->user_id }}"><i class="fa fa-eye"></i>查看</a>

                                        <a href="javascript:;" class="btn red uppercase btn red uppercase mt-sweetalert"
                                           style="margin-bottom: 0;"
                                           data-title="确定要该图片吗？"
                                           data-message="图片会从服务器上移除"
                                           data-type="warning"
                                           data-allow-outside-click="true"
                                           data-show-cancel-button="true"
                                           data-cancel-button-text="点错了"
                                           data-cancel-button-class="btn-danger"
                                           data-show-confirm-button="true"
                                           data-confirm-button-text="确定"
                                           data-confirm-button-class="btn-info"
                                           data-popup-title-success="删除成功"
                                           data-close-on-cancel="true"
                                           data-close-on-confirm="false"
                                           data-show-loader-on-confirm="true"
                                           data-ajax-url="{{ route('picture.destroy', $image->id) }}"
                                           data-remove-dom="image_li_"
                                           data-id="{{ $image->id }}"
                                           rel="nofollow"
                                        >
                                            <i class="fa fa-trash-o"></i>
                                            删除
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cbp-l-grid-projects-title uppercase text-center uppercase text-center" id="filename_{{ $image->id }}">{{ $image->filename }}</div>
                        <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">年月：{{ $image->year_month }}，占用空间：{{ human_filesize($image->size) }}</div>
                    </div>
                @endforeach
        </div>
            <div class="row" style="padding-top: 40px">
                <div class="col-md-5 col-sm-5"></div>
                <div class="col-md-5 col-sm-5">
                    <div class="dataTables_info" id="sample_editable_1_info" role="status" aria-live="polite">
                        当前第 {{ $images->currentPage() }} 页，共 {{ $images->total() }} 张图片
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div class="dataTables_paginate paging_bootstrap_number" id="sample_editable_1_paginate">
                        {{ $images->links() }}
                    </div>
                </div>
            </div>
        {{--<div id="js-loadMore-juicy-projects" class="cbp-l-loadMore-button">
            <a href="../assets/global/plugins/cubeportfolio/ajax/loadMore.html" class="cbp-l-loadMore-link btn grey-mint btn-outline" rel="nofollow">
                <span class="cbp-l-loadMore-defaultText">加载更多</span>
                <span class="cbp-l-loadMore-loadingText">正在加载...</span>
                <span class="cbp-l-loadMore-noMoreLoading">已经有没了</span>
            </a>
        </div>--}}
        @else
            <div class="panel panel-success">
                <div class="panel-body">
                    <ul>
                        <li> 暂无文件 </li>
                    </ul>
                </div>
            </div>

        @endif
    </div>
    <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">设置图片名称</h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:150px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>文件名</h4>
                                <p>
                                    <input type="hidden" class="col-md-12 form-control" id="image_id">
                                    <input type="text" class="col-md-12 form-control" id="filename">
                                </p>

                                <p class="alert alert-danger" style="display: none" id="filename_error">
                                    <strong>错误!</strong> 输入名称不能为空
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                    <button type="button" class="btn green" href="javascript:;" onclick="saveFilename()">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
                <td>
                    <span class="preview"></span>
                </td>
                <td>
                    <p class="name">{%=file.name%}</p>
                    <strong class="error text-danger label label-danger"></strong>
                </td>
                <td>
                    <p class="size">计算中...</p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                </td>
                <td> {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn blue start" disabled>
                        <i class="fa fa-upload"></i>
                        <span>开始</span>
                    </button> {% } %} {% if (!i) { %}
                    <button class="btn red cancel">
                        <i class="fa fa-ban"></i>
                        <span>取消</span>
                    </button> {% } %} </td>
            </tr> {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
                <td>
                    <span class="preview"> {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                            <img src="{%=file.thumbnailUrl%}">
                        </a> {% } %} </span>
                </td>
                <td>
                    <p class="name"> {% if (file.url) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
                        <span>{%=file.name%}</span> {% } %} </p> {% if (file.error) { %}
                    <div>
                        <span class="label label-danger">错误</span> {%=file.error%}</div> {% } %} </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
                <td> {% if (file.deleteUrl) { %}
                    <button class="btn red delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                        <i class="fa fa-trash-o"></i>
                        <span>删除</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle"> {% } else { %}
                    <button class="btn yellow cancel btn-sm">
                        <i class="fa fa-ban"></i>
                        <span>取消</span>
                    </button> {% } %} </td>
            </tr> {% } %}
    </script>
    <script src="{{ asset('vendor/cubeportfolio/js/jquery.cubeportfolio.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/picture/scripts/portfolio-1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/vendor/tmpl.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/vendor/load-image.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/vendor/canvas-to-blob.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.iframe-transport.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-process.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-image.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jquery-file-upload/js/jquery.fileupload-ui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/picture/scripts/form-fileupload.js') }}" type="text/javascript"></script>
    {{--sweetalert弹窗--}}
    <script src="{{asset('assets/admin/layouts/scripts/sweetalert/sweetalert-ajax-delete.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var url = "{{ route('picture.index') }}";
        /*alert()弹窗*/
        jQuery(document).ready(function() {
            SweetAlert.init();
        });

        // 获取更新ID
        function getId(id) {
            $('#image_id').val(id);
            $('#responsive').modal();
        }

        function saveFilename() {
            var id = $('#image_id').val();
            var filename = $('#filename').val();
            if (filename.length == 0) {
                $('#filename_error').show();
            } else {
                $('#filename_error').hide();
                var settings = {
                    type: "POST",
                    url: url + '/' + id + '/edit',
                    data: {filename : filename},
                    dataType:"json",
                    success: function(data) {
                        console.log(data);
                        if (data.code == 0) {
                            $('#responsive').modal('hide');
                            $('#filename_'+id).html(filename);
                            swal('修改成功', '点击按钮返回', 'success');
                        } else {
                            $('#responsive').modal('hide');
                            swal('修改失败', '点击按钮返回', 'error');
                        }
                        $('#filename').val('');
                    },
                    error: function (HttpRequest) {
                        if (HttpRequest.responseJSON.error == "no_permissions") {
                            sweetAlert({
                                title:"您没有此权限",
                                text:"请联系管理员",
                                type:"error"
                            });
                        } else {
                            sweetAlert({
                                title:'未知错误',
                                text:"请联系管理员",
                                type:"error"
                            });
                            return false;
                        }
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                };
                $.ajax(settings);
            }
        }
    </script>
@endsection
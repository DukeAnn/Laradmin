@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')
    <link href="{{ asset('vendor/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
    {!! editor_css() !!}
@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-8 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase"> 文章发布 </span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-pencil"></i> Edit </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-ban"></i> Ban </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;"> Make admin </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" enctype="multipart/form-data" method="post" action="@if($is_edit){{ route('article.update', [$article->id]) }}@else{{ route('article.store') }}@endif">
                        {{ csrf_field() }}
                        @if($is_edit)
                            <input type="hidden" name="_method" value="PUT">
                        @endif
                        <div class="form-body">
                            <div class="form-group @if($errors->has('title')) has-error @endif">
                                <label>文章标题</label>
                                <div class="input-icon">
                                    <i class="fa fa-keyboard-o font-green"></i>
                                    <input type="text" class="form-control" name="title" placeholder="文章标题"
                                           value="{{ $is_edit ? $article->title : old('title') }}"
                                    >
                                    @if($errors->has('title'))
                                        <span class="help-block">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label">文章分类</label>
                                <select id="multiple" class="form-control select2-multiple" multiple name="cates[]">
                                    @if(!empty($cates))
                                        @foreach($cates as $cate)

                                                <option value="{{ $cate->id }}"  @if($is_edit) {{ $article->hasCategory($cate->id) ? 'selected' : ''}} @endif>{{ $cate->name }}</option>
                                                @if(!empty($cate->child))
                                                    @foreach($cate->child as $item)
                                                    <option value="{{ $item->id }}" @if($is_edit) {{ $article->hasCategory($item->id) ? 'selected' : ''}} @endif>&nbsp;&nbsp;{{ $item->name }}</option>
                                                    @endforeach
                                                @endif

                                        @endforeach
                                    @else
                                        <optgroup label="未分类">
                                            <option value="0" disabled="disabled">请创建分类</option>
                                        </optgroup>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">文章标签</label>
                                <div class="">
                                    <select class="bs-select form-control" name="tags[]" data-live-search="true" data-size="8" multiple>
                                        @if(!empty($tags))
                                            @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}" @if($is_edit){{ $article->hasTag($tag->id)? 'selected ': '' }}@endif>{{ $tag->name }}</option>
                                            @endforeach
                                        @else
                                            <option>无标签</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group @if($errors->has('abstract')) has-error @endif">
                                <label>摘要</label>
                                <textarea class="form-control" name="abstract" rows="3">{{ $is_edit ? $article->abstract : old('abstract') }}</textarea>
                                @if($errors->has('abstract'))
                                    <span class="help-block">{{ $errors->first('abstract') }}</span>
                                @endif
                            </div>
                            <div class="form-group last">
                                <label class="control-label">文章特色图像</label>
                                <div class="">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="@if($is_edit){{ $article->article_image ?: asset('assets/admin/img/no_image.png') }}@else{{ asset('assets/admin/img/no_image.png') }}@endif" alt="" /> </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> 选择图片 </span>
                                                <span class="fileinput-exists"> 更换 </span>
                                                <input type="file" name="article_image">
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> 删除 </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group @if($errors->has('editormd-html-code')) has-error @endif">
                                <label>正文</label>
                                <div id="editormd">
                                    <textarea style="" id="article_content">{{ $is_edit ? $article->content_md : old('editormd-markdown-doc') }}</textarea>
                                </div>
                                @if($errors->has('editormd-html-code'))
                                    <span class="help-block">{{ $errors->first('editormd-html-code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue">发布</button>
                            <button type="button" class="btn default">取消</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
    <script src="{{ asset('vendor/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/layouts/scripts/components-select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/layouts/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/InlineAttachment/src/inline-attachment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/InlineAttachment/src/jquery.inline-attachment.js') }}" type="text/javascript"></script>
    {{-- Md编辑器 --}}
    {!! editor_js_a() !!}
    <script type="text/javascript">
        // 拖拽上传
        var inlineAttachmentOptions = {
            uploadUrl: '{{ route('article.uploadImage') }}',
            uploadFieldName: 'editormd-image-file',
            progressText: '![正在上传文件...]()',
            urlText: "\n ![file]({filename}) \n\n",
            extraParams: {
                "_token": '{{ csrf_token() }}'
            }
        };
        $('textarea').inlineattachment(inlineAttachmentOptions);
        // MKDown 编辑器
        $(function() {
            var editor = editormd("editormd");
        });

    </script>
@endsection
<?php
return [
    'width'=>'100%',//宽度建议100%
    'height'=>'700',//高度
    'theme'=>'default',//顶部的主题分为default和dark
    'editorTheme'=>'default',//显示区域的主题分为default和pastel-on-dark 注:如果想要配置其他主题，请参考vendor/editormd/lib/theme目录下的css文件
    'previewTheme'=>'default',//编辑区域的主题分为default,dark,
    'flowChart' => 'true',  //流程图
    'tex' => 'true',  //开启科学公式TeX语言支持
    'searchReplace'=>'true',//搜索替换
    'saveHTMLToTextarea' => 'true',  //保存 HTML 到 Textarea
    'codeFold' => 'true',  //代码折叠
    'emoji' => 'true',  //emoji表情
    'toc' => 'true',  //目录
    'tocm' => 'true',  //目录下拉菜单
    'taskList' => 'true',  //任务列表
    'imageUpload' => 'true',  //图片本地上传支持
    'imageUploadURL' => '/admin/article/upload_image', //自己配置上传方法 vendor/laravelchen/laravel-editormd/src/helper.php
    'sequenceDiagram' => 'true',  //开启时序/序列图支持
];

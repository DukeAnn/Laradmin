<?php
/**
 * 帮助函数
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2017/3/8 0008
 * Time: 15:06
 * @author DukeAnn
 */

use App\Repositories\Eloquent\AdminSettingRepositoryEloquent;
/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

/**
 * 获取系统设置的值
 * @param $code string 键值
 * @return string
 * */
if (!function_exists("getSetting")) {
    function getSetting($code)
    {
        $value = AdminSettingRepositoryEloquent::getValue($code);
        return $value;
    }
}

// editor.md JS
if (!function_exists("editor_js_a")) {
    function editor_js_a()
    {
        return '
<script src="/vendor/editormd/js/editormd.js"></script>
<script src="/vendor/editormd/lib/marked.min.js"></script>
<script src="/vendor/editormd/lib/prettify.min.js"></script>
<script src="/vendor/editormd/lib/raphael.min.js"></script>
<script src="/vendor/editormd/lib/underscore.min.js"></script>
<script src="/vendor/editormd/lib/sequence-diagram.min.js"></script>
<script src="/vendor/editormd/lib/flowchart.min.js"></script>
<script src="/vendor/editormd/lib/jquery.flowchart.min.js"></script>
<script>
    var testEditor;
    $(function () {
        editormd.emoji = {
            path: "//staticfile.qnssl.com/emoji-cheat-sheet/1.0.0/",
            ext: ".png"
        };
        testEditor = editormd({
            id: "editormd_id",
            width: "' . config('editormd.width') . '",
            height:' . config('editormd.height') . ',
            theme: "' . config('editormd.theme') . '",
            editorTheme:"' . config('editormd.editorTheme') . '",
            previewTheme:"' . config('editormd.previewTheme') . '",
            path: \'/vendor/editormd/lib/\',
            codeFold:' . config('editormd.codeFold') . ',
            saveHTMLToTextarea: ' . config('editormd.saveHTMLToTextarea') . ',
            searchReplace: ' . config('editormd.searchReplace') . ',
            emoji: ' . config('editormd.emoji') . ',
            taskList: ' . config('editormd.taskList') . ',
            tocm: ' . config('editormd.tocm') . ',
            tex: ' . config('editormd.tex') . ',
            flowChart: ' . config('editormd.flowChart') . ',
            sequenceDiagram: ' . config('editormd.sequenceDiagram') . ',
            imageUpload: ' . config("editormd.imageUpload") . ',
            imageFormats:["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL: "'. config("editormd.imageUploadURL") .'?token=' . csrf_token() .'",
        });
    })
</script>
    ';
    }
}
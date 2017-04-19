<?php
namespace App\Services;
/**
 * Created by PhpStorm.
 * User: ADKi
 * Date: 2017/3/8 0008
 * Time: 14:32
 * @author DukeAnn
 */

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Exceptions\ImageUploadException;
use Image;
use Auth;

class ImageUpload
{
    /**
     * @var UploadedFile $file
     */
    protected $file;

    // 允许的格式
    protected $allowed_extensions = ["png", "jpg", "gif", 'jpeg'];

    // 缩略图高度尺寸
    protected $height_arr = [];

    public function __construct()
    {
        // 设置缩略图尺寸
        $this->height_arr = [
            'big' => getSetting('upload_picture_thumbnail_max'),
            'middle' => getSetting('upload_picture_thumbnail_middle'),
            'small' => getSetting('upload_picture_thumbnail_small')
        ];
    }

    /**
     * 上传图片
     * @param $file UploadedFile
     * @return array 返回上传图片的路径数组
     * */
    public function uploadImage(UploadedFile $file)
    {
        $this->file = $file;
        // 检查格式
        $this->checkAllowedExtensionsOrFail();
        // 保存图片
        $local_image = $this->saveImageToLocal('topic', getSetting('upload_picture_mix'));
        return ['filename' => $local_image];
    }

    /*
     * 检查上传的格式
     * */
    protected function checkAllowedExtensionsOrFail()
    {
        $extension = strtolower($this->file->getClientOriginalExtension());
        if ($extension && !in_array($extension, $this->allowed_extensions)) {
            throw new ImageUploadException('你只能上传以下格式的图片：' . implode($this->allowed_extensions, ','));
        }
    }

    /**
     * 保存图片到本地
     * @param $type string 图片类型 topic 一般图片，avatar 头像
     * @param $resize int 最大宽度
     * @param $filename string 设置文件名
     * @return array 文件存储路径
     * */
    protected function saveImageToLocal($type, $resize, $filename = '')
    {
        $year_mouth = date("Ym", time());
        $folderName = ($type == 'avatar')
            ? 'upload/avatars'
            : 'upload/images/' . $year_mouth .'/'.date("d", time()) .'/'. Auth::user()->id;

        // 设置存储路径
        $destinationPath = public_path() . '/' . $folderName;
        $extension = $this->file->getClientOriginalExtension() ?: 'png';
        // 设置保存的文件名
        $filename = $filename ? :date("YmdHis", time()).'_'.str_random(2);
        $safeName  = $filename . '.' . $extension;
        // 保存文件
        $this->file->move($destinationPath, $safeName);
        // 主图
        $files['original'] = $folderName .'/'. $safeName;
        $files['extension'] = $extension;
        $files['filename'] = $filename;
        $files['year_month'] = $year_mouth;
        // 压缩文件
        if ($this->file->getClientOriginalExtension() != 'gif') {
            $img = Image::make($destinationPath . '/' . $safeName);

            $img->resize($resize, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save();

            // 生成缩略图
            foreach ($this->height_arr as $key => $height) {
                if ($height == 0) {
                    continue;
                }

                // 最小缩略图 5:3 居中裁剪
                if ($key == 'small') {
                    $img->fit($height / 3 * 5, $height);
                } else {
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                $safeName = $filename.'_'.$key.'.'.$extension;
                $img->save($destinationPath.'/'.$safeName);

                $files[$key] = $folderName .'/'.$safeName;
            }
        }
        return $files;
    }
}
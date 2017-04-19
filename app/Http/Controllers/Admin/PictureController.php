<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\ImageUpload;
use Image;
use App\Exceptions\ImageUploadException;
use Storage;
use App\Repositories\Eloquent\ImageRepositoryEloquent;
use Auth;

class PictureController extends Controller
{
    // 图片上传服务类
    protected $imageUpload;

    // 图片-模型
    protected $imageRepositoryEloquent;

    public function __construct(ImageUpload $imageUpload, ImageRepositoryEloquent $imageRepositoryEloquent)
    {
        $this->imageUpload = $imageUpload;

        $this->imageRepositoryEloquent = $imageRepositoryEloquent;
    }
    // 文件列表
    public function index()
    {
        $images = $this->imageRepositoryEloquent->getList(getSetting('admin_pages_length'));
        // 查询年月
        $year_months = $this->imageRepositoryEloquent->getYearMonth();
        $data = [
            'images' => $images,
            'year_months' => $year_months,
        ];
        return view('admin.picture.index', $data);
    }

    // 上传图片
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            try {
                $upload_status = $this->imageUpload->uploadImage($file[0]);
                $file_arr = $upload_status['filename'];
                $insert_id = $this->saveImageInfo($file_arr);
                if (!$insert_id) {
                    throw new ImageUploadException('文件写库失败');
                }
            } catch (ImageUploadException $exception) {
                $files['files'][0] = [
                    "name" => '图片上传失败',
                    "size" => 0,
                    'error' => $exception->getMessage()
                ];
                return response()->json($files);
            }

            $files['files'][0] = [
                "name" => basename($file_arr['original']),
                "size" => Storage::size($file_arr['original']),
                'url' => env('APP_URL').Storage::url($file_arr['original']),
                'thumbnailUrl' => env('APP_URL').Storage::url($file_arr['small']),
                'deleteUrl' => route('picture.destroy', ['id' => $insert_id]),
                'deleteType' => 'DELETE',
            ];
            return response()->json($files);
        }
    }

    /**
     * 保存图片信息到数据库
     * @param $file_arr array
     * @return string 插入ID
     * */
    protected function saveImageInfo($file_arr)
    {
        $insert_id = $this->imageRepositoryEloquent->saveImage($file_arr, Auth::user());
        return $insert_id;
    }

    /**
     * 删除图片
     * */
    public function destroy($id)
    {
        $image_info = $this->imageRepositoryEloquent->getInfo($id);
        if ($image_info) {
            if ($this->imageRepositoryEloquent->delete($id)) {
                $this->destroyImage($image_info);
                $data['files'][0] = [
                    basename($image_info->path) => true,
                ];
            } else {
                $data['files'][0] = [
                    basename($image_info->path) => false,
                ];
            }
        } else {
            $data['files'][0] = [
                '文件不存在' => false,
            ];
        }
        return response()->json($data);
    }

    /*
     * 删除服务器上的图片
     * */
    protected function destroyImage($image_info)
    {
        // 获取各个裁剪图删除
        $destinationPath = dirname($image_info->path);
        $small_image = $destinationPath.'/'.$image_info->name.'_small.'.$image_info->extension;
        $middle_image = $destinationPath.'/'.$image_info->name.'_middle.'.$image_info->extension;
        $big_image = $destinationPath.'/'.$image_info->name.'_big.'.$image_info->extension;

        Storage::delete($image_info->path);
        Storage::delete($small_image);
        Storage::delete($middle_image);
        Storage::delete($big_image);
    }

    /*
     * 修改文件名
     * */
    public function editFilename($id, Request $request)
    {
        $result = $this->imageRepositoryEloquent->edit($id, $request);
        if ($result) {
            $data = [
                'code' => 0,
                'message' => '修改成功'
            ];
        } else {
            $data = [
                'code' => 1,
                'message' => '修改失败'
            ];
        }
        return response()->json($data);
    }
}

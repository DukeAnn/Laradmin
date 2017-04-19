<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\AdminSettingRepositoryEloquent;

class SettingController extends Controller
{
    protected $adminSettingRepositoryEloquent;

    public function __construct(AdminSettingRepositoryEloquent $adminSettingRepositoryEloquent)
    {
        $this->adminSettingRepositoryEloquent = $adminSettingRepositoryEloquent;
    }

    /*
     * 首页
     * */
    public function index()
    {
        $set_all = $this->adminSettingRepositoryEloquent->getAll();

        return view('admin.setting.setting_index', compact('set_all'));
    }
    
    /*
     * 保存测试
     * */
    public function saveSet($id, Request $request)
    {
        $result = $this->adminSettingRepositoryEloquent->saveSet($id, $request);
        if ($result) {
            $data = [
                'code' => 0,
                'message' => '成功'
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

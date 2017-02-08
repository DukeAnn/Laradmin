<?php
/**
 * 会员中心
 * */
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class MemberController extends Controller
{
    protected $model_user;
    public function __construct(User $user)
    {
        $this->model_user = $user;
    }
    //会员中心首页
    public function index()
    {
        return view('member.index');
    }

    //编辑信息
    public function edit()
    {
        return view('member.edit');
    }

    /**
     * 编辑信息保存
     * @param Request $request
     * @return mixed
     * */
    public function editStore(Request $request)
    {
        $message = [
            'name.required' => '必须填写名字',
        ];
        $this->validate($request,
            [
                'name' => 'required',
            ],$message);
        $user_id = $request->user()->id;
        $user_info = User::findOrFail($user_id);
        $user_info->name = $request->name;
        if ($user_info->save()) {
            $request->session()->flash('message', '修改成功');
        }
        return redirect()->route('member.edit');
    }

    //重置密码
    public function password()
    {
        return view('member.password');
    }

    /**
     * 重置密码保存
     * @param Request $request
     * @return mixed
     * */
    public function passwordStore(Request $request)
    {
        $message = [
            'password.required' => '请填写密码',
            'password.min' => '密码最短6位',
            'password.confirmed' => '两次填写的密码不一致',
        ];
        $this->validate($request,
            [
                'password' => 'required|min:6|confirmed',
            ],$message);
        $user_id = $request->user()->id;
        $user_info = User::findOrFail($user_id);
        $user_info->password = bcrypt($request->password);
        if ($user_info->save()) {
            $request->session()->flash('message', '修改成功');
        }
        return redirect()->route('member.password');
    }
}

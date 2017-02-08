<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth 路由
Auth::routes();
//ajax登录
Route::post('ajax/login', 'Auth\LoginController@ajaxLogin')->name('ajax.login');
//ajax重置密码
Route::post('ajax/password/email', 'Auth\ForgotPasswordController@ajaxSendResetLinkEmail')->name('ajax.password.email');
//ajax注册
Route::post('ajax/register', 'Auth\RegisterController@ajaxRegister')->name('ajax.register');

//Admin后台路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'check.permission']] ,function () {
    //默认跳转首页
    Route::get('/', function () {
       return redirect('admin/index');
    });

    //后台入口
    Route::get('index', 'IndexController@index')->name('admin.index');

   //ajax获取二级菜单
    Route::get('getchildmenu', 'MenuTableController@ajaxGetChildMenu')->name('menutable.ajaxGetChild');
    //缓存保存菜单排序
    Route::post('savemenuorder', 'MenuTableController@saveOrder')->name('menutable.saveMenuOrder');
    //定制菜单,资源路由
    Route::resource('menutable', 'MenuTableController');
    //图标参考
    Route::get('icon', 'IndexController@icon')->name('admin.icon');
    //ajax获取用户列表
    Route::post('get_users', 'UserController@getUsers')->name('user.getUsers');
    //用户,资源路由
    Route::resource('user', 'UserController');
    //用户组,资源路由
    Route::resource('role', 'RoleController');
    //ajax获取权限列表
    Route::post('get_permissions', 'PermissionController@getPermissions')->name('permissions.getPermissions');
    //权限,资源路由
    Route::resource('permissions', 'PermissionController');
    //日志路由
    Route::get('log', 'LogViewerController@index')->name('log.index');
    Route::get('log/list', 'LogViewerController@listLogs')->name('log.list');
    Route::delete('log/delete', 'LogViewerController@delete')->name('log.destroy');
    Route::get('log/{date}', 'LogViewerController@show')->name('log.show');
    Route::get('log/{date}/download', 'LogViewerController@download')->name('log.download');
    Route::get('log/{date}/{level}', 'LogViewerController@showByLevel')->name('log.filter');
});

//
Route::group(['prefix' => 'member', 'namespace' => 'Member', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect('member/index');
    });
    //会员中心
    Route::get('index', 'MemberController@index')->name('member.index');
    //资料编辑
    Route::get('edit', 'MemberController@edit')->name('member.edit');
    //资料编辑保存
    Route::post('edit', 'MemberController@editStore')->name('member.edit');
    //重置密码
    Route::get('password', 'MemberController@password')->name('member.password');
    //重置密码保存
    Route::post('password', 'MemberController@passwordStore')->name('member.password');
});

//微信接口路由
Route::group(['prefix' => 'wechat', 'namespace' => 'Wechat'] ,function () {
    Route::any('/serve', 'WechatController@serve');
});
//微信需要授权的接口
Route::group(['prefix' => 'wechat/oauth', 'namespace' => 'Wechat', 'middleware' => ['web', 'wechat.oauth']] ,function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料

        dd($user);
    });
});



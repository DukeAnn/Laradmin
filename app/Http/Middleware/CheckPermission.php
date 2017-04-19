<?php
/**
 * 方法中检查是否有权限
 * */
namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Route;
use App\Models\Permission;
use Entrust;
use Request;

class CheckPermission
{
    /**
     * 根据路由名称查询路由绑定的权限
     * 使用Entrust门面查询是否有权限
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $uri = Route::currentRouteName();
        $permission_info = Permission::where(['uri' => $uri])->first();
        //如果查不到路由名对应的权限直接放行
        if (empty($permission_info)) {
            return $next($request);
        }
        //检查是否有权限
        if (!Entrust::can(Entrust::can($permission_info['name']))) {
            //ajax请求直接返回json
            if(Request::ajax()){
                return response()->json(["error" => "no_permissions"], 422);
            }
            //返回session('error');到原页面
            return back()->withInput()->withError('no_permissions');
        }
        //根据路由名称查询权限
        return $next($request);
    }
}

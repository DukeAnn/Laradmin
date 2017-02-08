<?php
/**
 * admin后入台初始加载数据
 * */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //获取后台左侧菜单数据
        view()->composer(
            'admin.layouts.sidebar', 'App\Http\ViewComposers\SidebarMenuComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use function foo\func;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 添加自定义验证规则,允许字母和 - _
        Validator::extend('allow_letter', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[a-zA-Z_-]+$/u', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 本地环境激活 代码提示插件
        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}

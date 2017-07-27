基于laravel5.4的后台管理系统
===========

必须使用redis缓存，文件和数据库缓存不支持 tags（）

windows redis 下载地址：http://pan.baidu.com/s/1i56thcD

快速使用 Redis 缓存以及 lv5 中的 Redis 缓存：https://laravel-china.org/topics/877

前端模板请自行购买，如有侵权请联系作者。

使用扩展
-----

用户权限角色扩展：`zizaco/entrust`

redis扩展：`predis/predis`

菜单选中激活扩展：`hieu-le/active`

数据库扩展：`prettus/l5-repository` 查询返回的数组格式

架构依赖说明：http://oomusou.io/laravel/laravel-architecture/

jQuery DataTables API for Laravel：`yajra/laravel-datatables-oracle`

日志读取扩展：`arcanedev/log-viewer`  app日志配置'log' => env('APP_LOG', 'daily'),

图片处理扩展：`intervention/image`

PHP Redis 扩展

PHP cURL 扩展

PHP OpenSSL 扩展

PHP fileinfo 拓展 素材管理模块需要用到

http://datatables.club/

https://datatables.yajrabox.com

行内编辑：https://vitalets.github.io/x-editable/docs.html

升级日志
-----

https://github.com/DukeAnn/Laradmin/blob/master/UpdateLog.md

安装方法
----

1.拉取代码到本地，

2.`composer install`

3.设置 `.evn` 配置文件连接数据库和默认邮件发送服务器，设置`APP_URL=http://laradmin.app`，执行`php artisan key:generate` 生成key。

4.运行迁移和填充

5.`php artisan migrate --seed`

安装完成

演示地址：http://admin.amyair.cn

测试账号：直接右上角注册即可

基本说明
----

1.权限管理扩展不使用l5数据库扩展。

2.后台左侧菜单自动对应选中状态要求网站全部路由都要命名，并且同一菜单选项下的路由命名前缀一致，
比如：`admin.index`,`admin.create`,`admin.show`,`admin.edit`等，资源型路由自动命名。 
后台左侧菜单上显示的都是index结尾的路由名。程序定向跳转时使用 `route();`。
顶级菜单下子分类的权限如果都被禁止了，请添加顶级菜单的用户权限，并设置成用户无权限，就不在显示该菜单。
后台菜单显示原理，通过菜单uri查询用户权限，如果设置了该权限，进行验证是否有权限，没有就不显示，如果没设置就默认无权限要求。
有子类的菜单项设置的uri不会输出在html中，只会输出一个JavaScript:;所以设置成不存在的路由名也不会报错，无子菜单的uri会用route()函数解析，
如果路由名不存在会报错。

3.页面内面包屑写入语言包，语言包中名称对应`Route::currentRouteName();`的值（路由名称），靠服务注入生成面包屑`App\Presenters\Admin\CrumbsService`，语言包中没定义的直接显示语言包的健值。

4.路由不可以用闭包路由，路由必须命名否则`Route::currentRouteName();`无法生效，并且权限验证和菜单跳转全部使用的都是路由名称。

5.权限认证使用权限绑定路由名在`app/Http/Middleware/CheckPermission.php`中间件中验证，表单提交权限放在`app/Http/Requests`中验证，如果路由名未绑定权限将不做权限限制。

6.后台添加菜单时不允许添加为存在的路由名称，否则网站会崩掉。因为添加完菜单就会在左侧显示，但是路由名不存在就无法解析导致报错。如果不小心写错，要执行 `php artisan cache:clear` 清除缓存，并删除数据库中插入的错误数据！刷新页面即可。

###json格式通用于API
``` json
{
    "code": 0,
    "url": http://...
    "message": "...",
    "errors": [
        {
            "code": 10000,
            "field": "user",
            "message": "用户 不存在。"
        }
    ],
    "pagination": {
        "total": 10,
        "per_page": 10,
        "current_page": 1,
        "last_page": 1,
        "from": 1,
        "to": 10
    },
    "data": {
        ...
    }
}
```
####json返回值说明
`code`处理结果状态码，成功为 0，必填

`url`处理成功之后的跳转地址，可不填

`message`处理完成的通知信息，可不填

`errors`请求报错信息

`pagination`请求的分页信息

`data`请求的数据信息

`errors`和`data`不能同时存在

返回使用

`return response(['code' => -1, 'message' => '账号或者密码错误'], 400);` 自动转换成json

或者

`return response()->json(['code' => -1, 'message' => '账号或者密码错误'], 400);`

AJAX解析
``` javascript
var settings = {
        type: "POST",
        data:{},
        url: url,
        dataType: "json",
        success: function (data) {
            if (data.code == 0) {
                window.location.href = data.url;
            }
        },
        error: function (XMLHttpRequest) {
            $('#login-error').show();
            if (XMLHttpRequest.responseJSON.code == -1){
                $('#login-error-message').text(XMLHttpRequest.responseJSON.message);
            } else {
                $('#login-error-message').text("请填写邮箱和密码");
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    $.ajax(settings)
```

数据库模型创建命令
----

`php artisan make:entity name`，自动创建模型文件，数据库迁移文件，Repository下面的两个文件，Providers文件，可选生成Presenter,Validator,Controller文件

`php artisan make:repository name`，生成模型文件，数据库迁移文件，Repository下面的两个文件

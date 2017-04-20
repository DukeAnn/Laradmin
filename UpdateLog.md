升级日志
===
----------
2017-04-20
----
1.修复列表显示XSS攻击BUG
2.升级依赖

2017-04-19
----
1.添加系统设置参数功能

2.添加博客文章发布，绑定分分类和标签功能

2017-03-09
----
1.添加上传图片功能，增加设置缩略图， `.env` 文件设置网站域名 `APP_URL`

2.添加后台设置常用选项 执行 `php artisan migrate`，`php artisan db:seed --class=AdminSettingSeeder`

2017-03-04
----

1.升级到laravel5.4

2.菜单导航判断了是否存在，不会由于添加了不存在的路由导致系统报错。感谢@freyo。

3.更新了composer镜像源`composer config -g repo.packagist composer https://packagist.composer-proxy.org`，官方源：`composer config -g repo.packagist composer https://packagist.org`。可以直接在composer.json，设置地址局部应用。
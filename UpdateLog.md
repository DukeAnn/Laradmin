##升级日志

----------


###2017-03-04

----------

1.升级到laravel5.4

2.菜单导航判断了是否存在，不会由于添加了不存在的路由导致系统报错。感谢@freyo。

3.更新了composer镜像源`composer config -g repo.packagist composer https://packagist.composer-proxy.org`，官方源：`composer config -g repo.packagist composer https://packagist.org`。可以直接在composer.json，设置地址局部应用。
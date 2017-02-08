<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建表
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->integer('parent_id')->default(0)->comment('父级ID');
            $table->integer('order')->default(0)->comment('排序，asc');
            $table->string('name', 50)->comment('名称');
            $table->string('icon', 50)->comment('字体图标');
            $table->string('uri', 50)->comment('路由名');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除表
        Schema::drop('menus');
    }
}

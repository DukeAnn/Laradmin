<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_users', function(Blueprint $table) {
            $table->increments('id')->comment('微信用户表ID');
            $table->string('openid', 50)->comment('OpenID');
            $table->string('nickname', 50)->comment('用户的昵称');
            $table->tinyInteger('sex')->comment('用户的性别，值为1时是男性，值为2时是女性，值为0时是未知');
            $table->string('city', 50)->comment('用户所在城市')->nullable();
            $table->string('country', 50)->comment('用户所在国家')->nullable();
            $table->string('province', 50)->comment('用户所在省份')->nullable();
            $table->string('language', 50)->comment('用户的语言，简体中文为zh_CN')->nullable();
            $table->string('headimgurl')->comment('用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。')->nullable();
            $table->integer('subscribe_time')->comment('用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间')->nullable();
            $table->string('unionid')->comment('只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。')->nullable();
            $table->string('remark', 50)->comment('公众号运营者对粉丝的备注，公众号运营者可在微信公众平台用户管理界面对粉丝添加备注')->nullable();
            $table->integer('groupid')->comment('用户所在的分组ID（兼容旧的用户分组接口）')->nullable();
            $table->string('tagid_list')->comment('用户被打上的标签ID列表')->nullable();
            $table->integer('pair_id')->comment('用户配对ID')->nullable()->default(0);
            $table->integer('pair_time')->comment('用户配对时间')->default(0);
            $table->timestamps();
            $table->index('openid');
            $table->index('unionid');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wechat_users');
	}

}

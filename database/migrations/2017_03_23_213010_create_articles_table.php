<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('文章标题');
            $table->string('abstract')->comment('文章摘要');
            $table->longText('content')->comment('文章内容');
            $table->longText('content_md')->comment('文章内容MarkDown');
            $table->string('article_image')->nullable()->comment('文章特色图片');
            $table->tinyInteger('article_status')->comment('文章状态，1：公共，2：私有');
            $table->tinyInteger('comment_status')->comment('评论状态');
            $table->string('display_name')->nullable()->comment('文章英文别名');
            $table->string('comment_count')->nullable()->comment('评论总数');
            $table->string('author')->comment('作者');
            $table->integer('user_id')->comment('作者ID');
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
		Schema::drop('articles');
	}

}

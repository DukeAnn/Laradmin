<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类名称');
            $table->string('describe')->nullable()->comment('描述');
            $table->string('display_name')->nullable()->comment('分类英文别名');
            $table->integer('parent_id')->default(0)->comment('父类ID');
            $table->integer('order')->default(1)->comment('排序，asc');
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
		Schema::drop('article_categories');
	}

}

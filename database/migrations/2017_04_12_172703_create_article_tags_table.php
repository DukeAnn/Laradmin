<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('标签名');
            $table->string('display_name')->nullable()->comment('标签英文别名');
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
		Schema::drop('article_tags');
	}

}

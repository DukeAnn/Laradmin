<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCateTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_cate', function(Blueprint $table) {
            $table->integer('article_id')->unsigned();
            $table->integer('article_category_id')->unsigned();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('article_category_id')->references('id')->on('article_categories')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['article_id', 'article_category_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('article_cate');
	}

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tag', function(Blueprint $table) {
            $table->integer('article_id')->unsigned();
            $table->integer('article_tag_id')->unsigned();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('article_tag_id')->references('id')->on('article_tags')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['article_id', 'article_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_tag');
    }
}

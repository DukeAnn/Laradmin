<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('user_name')->comment('用户名');
            $table->string('path')->comment('文件路径');
            $table->string('name')->comment('文件名');
            $table->string('filename')->comment('用户命名文件名');
            $table->string('extension')->comment('文件尾缀');
            $table->string('year_month')->comment('上传年月');
            $table->string('size')->comment('文件大小');
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
        Schema::dropIfExists('images');
    }
}

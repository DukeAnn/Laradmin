<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_messages', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->string('openid', 50)->comment('OpenID');
            $table->integer('create_time')->comment('消息创建时间（时间戳）');
            $table->bigInteger('msg_id')->comment('消息ID,64位');
            $table->string('msg_type', 50)->comment('消息类型,text、image、voice、video、shortvideo、location、link');
            $table->text('content')->comment('text文本消息内容')->nullable();
            $table->string('media_id', 100)->comment('image,voice,video消息媒体id，可以调用多媒体文件下载接口拉取数据。')->nullable();
            $table->string('pic_url', 100)->comment('image图片链接')->nullable();
            $table->string('format', 50)->comment('voice语音格式，如amr，speex等。')->nullable();
            $table->string('thumb_media_id', 50)->comment('video视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。')->nullable();
            $table->double('location_x', 10, 6)->comment('location地理位置维度')->nullable();
            $table->double('location_y', 10, 6)->comment('location地理位置经度')->nullable();
            $table->string('title', 100)->comment('link消息标题')->nullable();
            $table->string('description', 255)->comment('link消息描述')->nullable();
            $table->string('url', 255)->comment('link消息链接')->nullable();
            $table->tinyInteger('read_state')->comment('信息读取状态，0：已送达，1：已读')->default(0)->nullable();
            $table->timestamps();
            $table->index('openid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wechat_messages');
    }
}

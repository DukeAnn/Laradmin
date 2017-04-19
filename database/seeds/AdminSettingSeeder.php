<?php

use Illuminate\Database\Seeder;
use App\Models\AdminSetting;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminSetting::create([
            'name' => '后台分页',
            'code' => 'admin_pages_length',
            'value' => '20',
            'describe' => '页面通用分页长度',
            'tag' => 'admin',
            'type' => 'text',
        ]);

        AdminSetting::create([
            'name' => '上传图片原图最大宽度',
            'code' => 'upload_picture_mix',
            'value' => '1280',
            'describe' => '上传图片原图最大宽度',
            'tag' => 'admin',
            'type' => 'text',
        ]);

        AdminSetting::create([
            'name' => '上传图片缩略图高度',
            'code' => 'upload_picture_thumbnail_small',
            'value' => '180',
            'describe' => '上传图片缩略图高度，填0不裁剪',
            'tag' => 'admin',
            'type' => 'text',
        ]);

        AdminSetting::create([
            'name' => '上传图片中等高度',
            'code' => 'upload_picture_thumbnail_middle',
            'value' => '600',
            'describe' => '上传图片中等大小高度，填0不裁剪',
            'tag' => 'admin',
            'type' => 'text',
        ]);

        AdminSetting::create([
            'name' => '上传图片最大高度（0：不限制）',
            'code' => 'upload_picture_thumbnail_max',
            'value' => '0',
            'describe' => '上传图片最大高度，填0不裁剪',
            'tag' => 'admin',
            'type' => 'text',
        ]);
    }
}

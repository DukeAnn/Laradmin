<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('code')->comment('代码');
            $table->string('value');
            $table->string('describe')->comment('描述');
            $table->string('tag')->comment('分类标签');
            $table->enum('type', ['text', 'textarea', 'select', 'date', 'combodate', 'datetime', 'typeahead', 'checklist', 'select2', 'address', 'wysihtml5'])->default('text')->comment('类型');
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
		Schema::drop('admin_settings');
	}

}

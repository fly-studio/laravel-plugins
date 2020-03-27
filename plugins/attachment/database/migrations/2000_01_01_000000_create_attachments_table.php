<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachment_files', function (Blueprint $table) {
			$table->id();
			$table->string('basename', 255)->comment = '存储的文件名';
			$table->string('path', 255)->comment = '存储文件路径';
			$table->string('hash', 50)->index()->comment = '文件MD5';
			$table->unsignedBigInteger('size')->index()->comment = '文件大小';
			$table->timestamp('cdn_at')->nullable()->comment = '上传CDN的时间';
			$table->timestamps();
			$table->unique(['hash','size']);
			$table->softDeletes(); //软删除
		});

		Schema::create('attachments', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('afid')->default(0)->comment = 'AttachmentFile ID';
			$table->unsignedBigInteger('thumbnail_aid')->default(0)->comment = 'Thumbnail Attachment ID';
			$table->string('uuid', 50)->nullable()->unique()->comment = '上传的uuid';
			$table->unsignedInteger('chunk_count')->default(1)->index()->comment = '块数';
			$table->string('original_name', 255)->comment = '原始文件名';
			$table->string('filename', 255)->comment = '新文件名(下载用)';
			$table->string('ext', 50)->index()->comment = '文件扩展名';
			$table->json('extra')->nullable()->comment = '其它内容';
			$table->unsignedBigInteger('uid')->nullable()->default(0)->comment = '用户ID';

			$table->timestamps(); //创建/修改时间
		});

		Schema::create('attachment_chunks', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('aid')->default(0)->comment = 'Attachment ID';
			$table->unsignedInteger('index')->default(0)->index()->comment = '第几块';
			$table->unsignedBigInteger('start')->default(0)->index()->comment = '起始字节';
			$table->unsignedBigInteger('end')->default(0)->index()->comment = '结束字节';
			$table->string('basename', 255)->comment = '存储的文件名(包含扩展名)';
			$table->string('path', 255)->comment = '存储文件路径';
			$table->string('hash', 50)->index()->comment = '文件MD5';
			$table->unsignedBigInteger('size')->index()->comment = '文件大小';
			$table->timestamps();
			//$table->unique(['hash','size']);
			$table->softDeletes(); //软删除
			$table->foreign('aid')->references('id')->on('attachments')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attachment_files');
		Schema::drop('attachments');
	}
}

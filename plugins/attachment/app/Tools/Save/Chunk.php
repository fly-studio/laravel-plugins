<?php

namespace Plugins\Attachment\App\Tools\Save;

use DB;
use Plugins\Attachment\App\Tools\File;
use Illuminate\Database\Eloquent\Model;
use Plugins\Attachment\App\Tools\Utils\Path;
use Plugins\Attachment\App\Contracts\Tools\Save;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;
use Plugins\Attachment\App\AttachmentChunk;

class Chunk extends Save {

	public function save()
	{
		$file = $this->manager->file();
		$chunks = $this->manager->chunks();
		$user = $this->manager->user();

		//传文件都耗费了那么多时间,还怕md5?
		$hash = $file->hash();
		$size = $file->size();

		DB::beginTransaction();
		//此处如果使用先select再insert，容易出现uuid重复冲突，如果在select中启用for update，则会DeadLock
		//在本地调试时，分块文件会同时上传（差异时间可忽略），导致同时进行的select为空，却重复在插入，即使使用文件锁，for update都不行。只能使用SyncMutex解决问题，但是需要安装sync插件
		//最终选择了insert into  on duplicate key update 这种方式来解决
		$attachment = (new Attachment)->insertUpdate([
			'uuid' => $chunks['uuid'],
			'chunk_count' => $chunks['count'],
			'afid' => 0,
			'filename' => $this->manager->filename(),
			'ext' => $this->manager->ext(),
			'original_name' => $file->getClientOriginalName(),
			'extra' => $this->manager->extra(),
			'uid' => $user instanceof Model ? $user->getKey() : $user,
		]);

		$hashName = Path::generateHashName(); //此函数并未检查attachment_chunks表中的basesize 是否有重复
		$hashPath = Path::hashNameToPath($hashName);
		$this->forceSaveToLocal($file->getPathName(), $hashPath);

		AttachmentChunk::create([
			'aid' => $attachment->getKey(),
			'basename' => $hashName,
			'path' => $hashPath,
			'hash' => $hash,
			'size' => $size,
			'index' => $chunks['index'],
			'start' => $chunks['start'],
			'end' => $chunks['end'],
		]);
		DB::commit();

		$this->mergeChunk($attachment->getKey());

		return $attachment;
	}

	private function mergeChunk($aid)
	{
		DB::beginTransaction();
		$attachment = Attachment::where('id', $aid)->lockForUpdate()->first();

		if ($attachment->chunks()->count() != $attachment->chunk_count || !empty($attachment->afid))
		{
			DB::rollback();
			return false; //未完整的得到文件
		}

		//合并文件
		$mergedPath = tempnam(sys_get_temp_dir(), 'attachment-'.$attachment->getKey());
		$fw = fopen($mergedPath, 'wb');
		foreach ($attachment->chunks()->orderBy('index', 'ASC')->get() as $chunk) //严格模式下$attachment->chunks()->count()不能有orderBy，所以将orderBy放在这里
		{
			$path = $chunk->full_path;
			if (!file_exists($path) || !is_readable($path)) {
				DB::rollback();
				throw new AttachmentException('lost_chunk', 'error');
			}
			$fr = fopen($path, 'rb');
			while(!feof($fr))
			{
				$stream = fread($fr, config('attachment.write_cache'));
				fwrite($fw, $stream);unset($stream);
			}
			fclose($fr);
			@unlink($path); //读取完毕就删除，没有保留的必要
		}
		fclose($fw);

		$attchamentFile = $this->saveToAttachmentFile(new File($mergedPath, mb_basename($mergedPath)));
		$attachment->update(['afid' => $attchamentFile->getKey()]);
		DB::commit();

		return true;
	}
}
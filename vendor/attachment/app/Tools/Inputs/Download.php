<?php
namespace Plugins\Attachment\App\Tools\Inputs;

use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use Plugins\Attachment\App\Tools\File;
use Plugins\Attachment\App\Contracts\Tools\Input;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Download extends Input {

	private $url;

	public function __construct()
	{
		ignore_user_abort(true);
		set_time_limit(0);		
	}

	public function download($url)
	{
		$this->url = $url;
		if (empty($url) || !filter_var($url, 'FILTER_VALIDATE_URL'))
			throw new AttachmentException('url_invalid');

		$filePath = tempnam(sys_get_temp_dir(),'download-');
		try {
			$originalName = $this->GuzzleHttp($filePath);
			return $this->newSave()->file(new File($filePath, $originalName))->deleteFileAfterSaved();
		} catch (\Exception $e) {
			@unlink($filePath);
			throw $e;
			return false;
		}
	}
	
	protected function GuzzleHttp($toPath)
	{
		$stack = HandlerStack::create();
		$stack->push(
			Middleware::log(
				app('log'),
				new MessageFormatter('GuzzleHttp {uri}'.PHP_EOL.PHP_EOL.'{request}'.PHP_EOL.PHP_EOL.'{response}'.PHP_EOL.PHP_EOL.'{error}')
			)
		);

		try {
			 $client = new \GuzzleHttp\Client([
				'handler' => $stack,
				'verify' => false,
				'sink' => $toPath,
			]);
			$res = $client->get($this->url);
		} catch (\Exception $e) {
			throw new AttachmentException('download_no_response');
		}
		if ($res->getStatusCode() != 200)
			throw new AttachmentException('download_no_response');

		$download_filename = $res->getHeader('Content-Disposition');

		$basename = mb_basename($url);//pathinfo($url,PATHINFO_BASENAME);
		if (!empty($download_filename))
		{
			if (preg_match('/filename\s*=\s*(\S*)/i',  $download_filename, $matches))
				$basename = mb_basename(trim($matches[1],'\'"'));
		}
		return $basename;
	}
}
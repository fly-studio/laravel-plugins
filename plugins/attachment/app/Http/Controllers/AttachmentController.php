<?php
namespace Plugins\Attachment\App\Http\Controllers;

use Agent, Auth, Mimes;
use Illuminate\Http\Request;
use Addons\Core\Controllers\Controller;
use Addons\Core\Http\Response\TextResponse;
use Plugins\Attachment\App\Tools\InputManager;
use Plugins\Attachment\App\Tools\OutputManager;
use Plugins\Attachment\App\Tools\SyncManager;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;
use Plugins\Attachment\App\AttachmentFile;

class AttachmentController extends Controller {

	public $permissions = ['uploaderQuery,fullavatarQuery,kindeditorQuery,ueditorQuery,dataurlQuery,editormdQuery,hashQuery' => 'attachment.create'];

	public function __construct()
	{
		$this->middleware('flash-session');
	}

	public function index(Request $request)
	{
		if (!$request->offsetExists('id'))
			throw (new AttachmentException('attachment::attachment.failure_notexists'))->setStatusCode(404);
		$route = 'attachment';
		$parameters = ['id' => $request->query('id')];
		if ($request->offsetExists('m'))
		{
			$route .= '-watermark';
			$parameters += [
				'watermark' => $request->query('m'),
			];
		}
		if ($request->offsetExists('width') || $request->offsetExists('height'))
		{
			$route .= '-resize';
			$parameters += [
				'width' => intval($request->query('width')),
				'height' => intval($request->query('height')),
			];
		}
		$url = url()->route($route, $parameters);
		return redirect($url);
	}

	private function factory($id, $strict = true)
	{
		$_id = Attachment::decode($id);
		if ($_id === false && $strict)
			throw (new AttachmentException('attachment::attachment.failure_invalid_id'))->setStatusCode(404);
		else if ($_id !== false)
			$id = $_id;

		$attachment = Attachment::mix($id);
		if (empty($attachment))
			throw (new AttachmentException('attachment::attachment.failure_notexists'))->setStatusCode(404);
		else if(empty($attachment->afid))
			throw (new AttachmentException('attachment::attachment.failure_file_notexists'))->setStatusCode(404);
		//获取远程文件
		app(SyncManager::class)->recv($attachment->path);

		return $attachment;
	}

	public function show(Request $request, $id, $filename = null)
	{
		/*
		//parse route error, is it required?
		if (in_array($id, ['download', 'preview', 'phone']))
		{
			list($_id) = explode('.', $filename);
			return $this->$id($request, $_id);
		}*/

		$attachment = $this->factory($id);
		if ($attachment->file_type == 'image')
		{
			if ( Agent::isMobile() && !Agent::isTablet() )
				return $this->phone($request, $id);
			else
				return $this->preview($request, $id);
		} else 
			return $this->download($request, $id);		
	}

	public function download(Request $request, $id)
	{
		$attachment = $this->factory($id);

		return app(OutputManager::class)->attachment($attachment)->send();
	}

	public function info(Request $request, $id)
	{
		$attachment = $this->factory($id, false);

		return $this->api($attachment->toArray());
	}

	public function resize(Request $request, $id, $width = 0, $height = 0)
	{
		$attachment = $this->factory($id);
		if ($attachment->file_type != 'image')
			throw new AttachmentException('image_invalid', 'error');

		return app(OutputManager::class)->attachment($attachment)->resize($width, $height);
	}

	public function phone(Request $request, $id)
	{
		$attachment = $this->factory($id);

		if ($attachment->file_type == 'image')
 			return $this->resize($request, $id, 640, 960);
		else
			return $this->preview($request, $id);
	}

	public function preview(Request $request, $id)
	{
		$attachment = $this->factory($id);

		return app(OutputManager::class)->attachment($attachment)->preview();
	}

	public function watermark(Request $request, $id, $watermark, $width = 0, $height = 0)
	{
		$attachment = $this->factory($id);
		if ($attachment->file_type != 'image')
			throw new AttachmentException('image_invalid', 'error');

		$watermark = Attachment::mix($watermark);
		if (empty($watermark) || !file_exists($watermark->full_path) || $watermark->file_type != 'image')
			throw new AttachmentException('watermark_invalid', 'errror');

		return app(OutputManager::class)->attachment($attachment)->watermark($watermark, $width, $height);
	}

	public function hashQuery(Request $request)
	{
		$hash = $request->input('hash');
		$size = $request->input('size');
		$filename = $request->input('filename');
		$ext = $request->input('ext');

		if (empty($hash) || empty($size) || empty($filename))
			return $this->error_param()->setStatusCode(404);

		$attachment = app(InputManager::class)
			->hash($hash, $size, $filename)
			->user($request->user())
			->save();
		return $this->api($attachment);
	}

	public function uploaderQuery(Request $request)
	{
		$uuid = $request->input('uuid', '');
		$count = $request->input('chunks', 1);
		$index = $request->input('chunk', '');
		$total = $request->input('total', 0);
		$start = $request->input('start', 0);
		$end = $request->input('end', 0);
		$hash = $request->input('hash', '');

		$attachment = app(InputManager::class)
			->upload('Filedata')
			->chunks(compact('uuid', 'count', 'index', 'start', 'end', 'total', 'hash'))
			->user($request->user())
			->save();

		return $this->api($attachment);
	}

	public function editormdQuery(Request $request)
	{
		$data = ['success' => 1, 'message' => ''];
		try {
			$attachment = app(InputManager::class)
				->upload('editormd-image-file')
				->user($request->user())
				->save();
			$data['url'] = $attachment->url;
			
		} catch (\Exception $e) {
			$data = ['success' => 0, 'message' => $e->getMessage()];
		}
		
		return (new TextResponse)->setData($data, true);
	}

	public function kindeditorQuery(Request $request)
	{
		$data = ['error' => 0, 'url' => ''];
		try {
			$attachment = app(InputManager::class)
				->upload('Filedata')
				->user($request->user())
				->save();
			$data['url'] = $attachment->url;
		} catch (\Exception $e) {
			$data = ['error' => 1, 'message' => $e->getMessage()];
		}
		return (new TextResponse)->setData($data, true);
	}

	public function ueditorQuery(Request $request, $start = 0, $size = null)
	{
		$data = array();
		$_config = config('attachment');
		$action = $request->query('action');
		$page = !empty($size) ? ceil($start / $size) : 1;
		switch ($action) {
			case 'config':
				$data = array(
					/* 上传图片配置项 */
					'imageActionName' => 'uploadimage', /* 执行上传图片的action名称 */
					'imageFieldName' => 'Filedata', /* 提交的图片表单名称 */
					'imageCompressEnable' => true, /* 是否压缩图片,默认是true */
					'imageCompressBorder' => 1600, /* 图片压缩最长边限制 */
					'imageUrlPrefix' => '',
					'imageInsertAlign' => 'none', /* 插入的图片浮动方式 */
					'imageAllowFiles' => array_map(function($v) {return '.'.$v;}, $_config['file_type']['image']),
					/* 涂鸦图片上传配置项 */
					'scrawlActionName' => 'uploadscrawl', /* 执行上传涂鸦的action名称 */
					'scrawlFieldName' => 'Filedata', /* 提交的图片表单名称 */
					'scrawlUrlPrefix' => '', /* 图片访问路径前缀 */
					'scrawlInsertAlign' => 'none',
					/* 截图工具上传 */
					'snapscreenActionName' => 'uploadimage', /* 执行上传截图的action名称 */
					'snapscreenUrlPrefix' => '', /* 图片访问路径前缀 */
					'snapscreenInsertAlign' => 'none', /* 插入的图片浮动方式 */
					/* 抓取远程图片配置 */
					'catcherLocalDomain' => array('127.0.0.1', 'localhost', 'img.bidu.com'),
					'catcherActionName' => 'catchimage', /* 执行抓取远程图片的action名称 */
					'catcherFieldName' => 'Filedata', /* 提交的图片列表表单名称 */
					'catcherUrlPrefix' => '', /* 图片访问路径前缀 */
					'catcherAllowFiles' => array_map(function($v) {return '.'.$v;}, $_config['file_type']['image']),
					/* 上传视频配置 */
					'videoActionName' => 'uploadvideo', /* 执行上传视频的action名称 */
					'videoFieldName' => 'Filedata', /* 提交的视频表单名称 */
					'videoUrlPrefix' => '', /* 视频访问路径前缀 */
					'videoAllowFiles' => array_map(function($v) {return '.'.$v;}, $_config['file_type']['video'] + $_config['file_type']['audio']),
					/* 上传文件配置 */
					'fileActionName' => 'uploadfile', /* controller里,执行上传视频的action名称 */
					'fileFieldName' => 'Filedata', /* 提交的文件表单名称 */
					'fileUrlPrefix' => '', /* 文件访问路径前缀 */
					'fileAllowFiles' => array_map(function($v) {return '.'.$v;}, $_config['ext']),
					/* 列出指定目录下的图片 */
					'imageManagerActionName' => 'listimage', /* 执行图片管理的action名称 */
					'imageManagerInsertAlign' => 'none', /* 插入的图片浮动方式 */
					'imageManagerUrlPrefix' => '',
					/* 列出指定目录下的文件 */
					'fileManagerActionName' => 'listfile', /* 执行文件管理的action名称 */
					'fileManagerUrlPrefix' => '',
				);
				break;
			 /* 上传图片 */
			case 'uploadimage':
			/* 上传视频 */
			case 'uploadvideo':
			/* 上传文件 */
			case 'uploadfile':
				try {
					$attachment = app(InputManager::class)
						->upload('Filedata')
						->user($request->user())
						->save();
					$data = [
						'state' => 'SUCCESS',
						'url' => $attachment->url,
						'title' => $attachment->original_name,
						'original' => $attachment->original_name,
						'type' => !empty($attachment->ext) ? '.'.$attachment->ext : '',
						'size' => $attachment->size,
					];
				} catch (\Exception $e) {
					$data = ['state' => $e->getMessage()];
				}
				break;
			/* 上传涂鸦 */
			case 'uploadscrawl':
				try {
					$attachment = app(InputManager::class)
						->raw(base64_decode($request->input('Filedata')), 'scrawl_'.(Auth::check() ? $request->user()->getKey() : 0).'_'.date('Ymdhis').'.png')
						->user($request->user())
						->save();
					$data = [
						'state' => 'SUCCESS',
						'url' => $attachment->url,
						'title' => $attachment->original_name,
						'original' => $attachment->original_name,
						'type' => !empty($attachment->ext) ? '.'.$attachment->ext : '',
						'size' => $attachment->size,
					];
				} catch (\Exception $e) {
					$data = ['state' => $e->getMessage()];
				}
				break;
			/* 抓取远程文件 */
			case 'catchimage':
				$urls = array_wrap($request->input('Filedata', []));
				$list = [];
				foreach ($urls as $url) {
					try {
						$attachment = app(InputManager::class)
						->download($url)
						->extra(['url' => $url])
						->user($request->user())
						->save();
						$list[] = [
							'state' => 'SUCCESS',
							'url' => $attachment->url,
							'title' => $attachment->original_name,
							'original' => $attachment->original_name,
							'size' => $attachment->size,
							'source' => $url,
						];
					} catch (\Exception $e) {
						$list[] = ['state' => $e->getMessage()];
					}
				}
				$data = [
					'state'=> !empty($list) ? 'SUCCESS' : 'ERROR',
					'list'=> $list,
				];
				break;
			 /* 列出图片 */
			case 'listimage':
			/* 列出文件 */
			case 'listfile':
				$list = Attachment::whereIn('ext', $_config['file_type']['image'])->orderBy('created_at', 'DESC')->paginate($size, ['*'], 'page', $page);
				
				$urls = [];
				foreach($list as $v)
					$urls[] = [ 'url' => $v->url ];

				$data = array(
					'state' => 'SUCCESS',
					'list' => $urls,
					'start' => $list->firstItem(),
					'total' => $list->total(),
				);
				break;
			default:
				break;
		}
		return (new TextResponse)->setData($data, true);
	}

	public function fullavatarQuery(Request $request)
	{
		$_config = config('attachment');
		$result = ['success' => true];
		if (isset($_FILES['__source']))
		{
			try {
				$attachment = app(InputManager::class)
					->upload('__source')
					->user($request->user())
					->save();
				$result['original_aid'] = $attachment['id'];
			} catch (\Exception $e) {
				$result = ['success' => false, 'message' => $e->getMessage()];
			}
		}
		if ($result['success'])
		foreach (['__avatar1', '__avatar2', '__avatar3'] as $v)
		{
			if (isset($_FILES[$v]) && is_uploaded_file($_FILES[$v]["tmp_name"]) && !$_FILES[$v]["error"]){

				try {
					$attachment = app(InputManager::class)
						->upload($v)
						->user($request->user())
						->filename($v.(Auth::check() ? $request->user()->getKey() : 0).'_'.date('Ymdhis').'.jpg')
						->save();
					$result['avatar_aids'][] = $attachment['id'];
				} catch (Exception $e) {
					$result = ['success' => false, 'message' => $e->getMessage()];
					break;
				}
			}
		}

		return (new TextResponse)->setData($result, true);
	}

	public function dataurlQuery(Request $request)
	{
		$dataurl = $request->post('DataURL');
		
		$part = parse_dataurl($dataurl);
		$ext = Mimes::getInstance()->ext_by_mime($part['mine']);
		$attachment = app(InputManager::class)
			->raw($part['data'], 'datauri_'.(Auth::check() ? $request->user()->getKey() : 0).'_'.date('Ymdhis').'.'.$ext)
			->user($request->user())
			->save();
		unset($dataurl, $part);
		return $this->success('', $url, array('id' => $attachment->getKey(), 'url' => $attachment->url));
	}



}
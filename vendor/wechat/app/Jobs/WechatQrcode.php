<?php
namespace Plugins\Wechat\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Plugins\Wechat\App\WechatQrcode as WechatQrcodeModel;
use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\Tools\Attachment;
class WechatQrcode implements ShouldQueue
{
	use Queueable;
	use InteractsWithQueue, SerializesModels;

	public $qrcodeID;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($id)
	{
		$this->qrcodeID = $id;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$qr = WechatQrcodeModel::find($this->qrcodeID);
		if (empty($qr))
			return false;

		if (empty($qr->aid))
		{
			$account = $qr->account;
			$attachment = new Attachment($account->toArray(), $account->getKey());
			$a = $attachment->downloadByTicket($qr->ticket);
			!empty($a) && $qr->update(['aid' => $a['id']]);
		}
		
	}
}

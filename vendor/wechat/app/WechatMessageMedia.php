<?php
namespace Plugins\Wechat\App;

use Addons\Core\Models\Model;
use Plugins\Wechat\App\WechatMessageMediaTrait;
class WechatMessageMedia extends Model{
	use WechatMessageMediaTrait;

	public $auto_cache = true;
	protected $guarded = [];
	public $incrementing = false;

	public function message()
	{
		return $this->hasOne(get_namespace($this).'\\WechatMessage', 'id', 'id');
	}

}
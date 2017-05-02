<?php
namespace Plugins\Wechat\App;

use App\Model;
use Plugins\Wechat\App\WechatMessage;
use Plugins\Wechat\App\WechatAccount;

class WechatReply extends Model{
	protected $guarded = ['id'];

	public $fire_caches = ['wechat-replies'];

	const MATCH_TYPE_WHOLE = 'whole';
	const MATCH_TYPE_PART = 'part';
	const MATCH_TYPE_SUBSCRIBE = 'subscribe';
	const REPLY_TYPE_RANDOM = 'random';
	const REPLY_TYPE_ALL = 'all';

	public function account()
	{
		return $this->hasOne(get_namespace($this).'\\WechatAccount', 'id', 'waid');
	}


	public function depots()
	{
		return $this->belongsToMany(get_namespace($this).'\\WechatDepot', 'wechat_reply_depot', 'wrid', 'wdid');
	}

	public function getDepots()
	{
		return $this->reply_count > 0 ? $this->depots->random($this->reply_count) : $this->depots;
	}

	public function getReplies()
	{
		return $this->rememberCache('wechat-replies', function(){
			$result = [];
			foreach(static::all() as  $v)
				if ($v['match_type'] == static::MATCH_TYPE_SUBSCRIBE)
					$result[ $v['waid'] ] [ $v['match_type'] ] = $v;
				else
					$result[ $v['waid'] ] [ $v['match_type'] ] [ $v['keywords'] ] = $v;
			
			return $result;
		});
	}

	/**
	 * 检索关键字回复
	 * 
	 * @param  Plugins\Wechat\App\WechatMessage $message
	 * @return Illuminate\Support\Collection [Plugins\Wechat\App\WechatDepots, ...]
	 */
	public function autoReply(WechatMessage $message)
	{
		$replies = $this->getReplies();
		$result = null;
		if (isset($replies[$message->waid][static::MATCH_TYPE_WHOLE]) && array_key_exists($message->text->content, $replies[$message->waid][static::MATCH_TYPE_WHOLE])) {
			$result = $replies[$message->waid][static::MATCH_TYPE_WHOLE][$message->text->content];
		} elseif (isset($replies[$message->waid][static::MATCH_TYPE_PART])) {
			$replace = array_map(function($v) {return '#$@{'.$v->getKey().'}@$#'; }, $replies[$message->waid][static::MATCH_TYPE_PART]);
			$content = strtr($message->text->content, $replace);
			if (strcmp($content, $message->text->content) != 0) { //有匹配对象
				if (preg_match('/#\$@\{(\d*)\}@\$#/i', $content, $matches))
					is_numeric($matches[1]) && $result = static::find($matches[1]);
			}
		}
		unset($replies);
		return !empty($result) ? $result->getDepots() : $this->newCollection();
	}

	/**
	 * 关注自动回复
	 * 
	 * @param  Plugins\Wechat\App\WechatAccount $account
	 * 
	 * @return Illuminate\Support\Collection [Plugins\Wechat\App\WechatDepots, ...]
	 */
	public function subscribeReply(WechatAccount $account)
	{
		$replies = $this->getReplies();
		return isset($replies[$account->getKey()][static::MATCH_TYPE_SUBSCRIBE]) ? $replies[$account->getKey()][static::MATCH_TYPE_SUBSCRIBE]->getDepots() : $this->newCollection();
	}
}
<?php

namespace Plugins\Wechat\App;

use App\Model;

class WechatDepotNews extends Model {

	protected $guarded = ['id'];
	protected $casts = [
		'redirect' => 'boolean',
		'cover_in_content' => 'boolean',
	];

	public function account()
	{
		return $this->hasOne(get_namespace($this).'\\WechatAccount', 'id', 'waid');
	}

	public function depots()
	{
		return $this->belongsToMany(get_namespace($this).'\\WechatDepot', 'wechat_depot_news_relation', 'wnid', 'wdid');
	}

}

<?php
namespace Plugins\Manual\App;

use Addons\Core\Models\Tree;
use Plugins\Manual\App\ManualHistory;

class Manual extends Tree {

	function histories()
	{
		return $this->hasMany(get_namespace($this).'\\ManualHistory', 'mid', 'id');
	}
}

Manual::updating(function($manual){
	if ($manual->isDirty('title', 'content'))
	{
		$data = Manual::find($manual->getKey(), ['title', 'content', 'id AS mid'])->toArray();
		ManualHistory::create($data);
	}
});

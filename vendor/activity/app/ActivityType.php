<?php
namespace Plugins\Activity\App;

use Addons\Core\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityType extends Model{
	use SoftDeletes;
	public $auto_cache = false;
	protected $guarded = ['id'];	
	
	//拥有多少个活动
	public function activity()
	{
	    return $this->hasMany(get_namespace($this).'\\Activity','type_id','id');
	}
}
<?php
namespace Plugins\Activity\App;

use Addons\Core\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model{
	use SoftDeletes;
	public $auto_cache = true;
	protected $guarded = ['id'];
	
	const NONE = 0; //未上架
	const ON = 1; //已上架
	const OFF = -1; //已下架
	//活动类型
	public function activity_type()
	{
		return $this->hasOne(get_namespace($this).'\\ActivityType', 'id', 'type_id');
	}
	//拥有多少个商品
	public function products()
	{
	    return $this->hasMany('App\\Product','activity_type','id');
	}
	//厂商
	public function factory()
	{
	    return $this->belongsTo('App\\Factory', 'fid', 'id');
	}
	
	public function status_tag()
	{
	    $status_tag = '';
	    switch ($this->status){
	        case static::NONE:$status_tag='未上架';break;
	        case static::ON:$status_tag='已上架'; break;
	        case static::OFF:$status_tag='已下架'; break;
	        default: $status_tag='未知';
	    }
	    return $status_tag;
	}
}
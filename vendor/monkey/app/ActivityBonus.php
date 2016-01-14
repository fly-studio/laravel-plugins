<?php
namespace Plugins\Monkey\App;

use Addons\Core\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityBonus extends Model{
	use SoftDeletes;
	public $auto_cache = false;
	protected $guarded = ['id'];
	protected $appends = ['status_tag'];
	
	public function users(){
	    return $this->hasOne('App\User','id','uid');
	}
	
	public function factory()
	{
	    return $this->hasOne('App\\Factory', 'id', 'fid');
	}
	
	public function activity()
	{
	    return $this->hasOne('Plugins\\Activity\\App\\Activity','id','activity_id');
	}
	
    public function getStatusTagAttribute()
	{
	    $order_tag = "未确定";
	    switch ($this->status){
	        case 0:
	            $order_tag = '未使用';break;
	        case 1:
	            $order_tag = '锁定中';break;
	        case 2:
	            $order_tag = '已使用';break;
	    }
		return $order_tag;
	}
}
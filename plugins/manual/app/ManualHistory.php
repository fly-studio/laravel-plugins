<?php
namespace Plugins\Manual\App;

use App\Model;
use Plugins\Manual\App\ManualHistory;

class ManualHistory extends Model {

	//不能批量赋值
	public $fire_caches = [];


	protected $guarded = ['id'];

	public function restore()
	{
		Manual::findOrFail($this->mid)->update([
			'title' => $this->title,
			'content' => $this->content,
		]);
	}
}

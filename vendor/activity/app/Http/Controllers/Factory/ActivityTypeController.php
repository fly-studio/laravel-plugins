<?php

namespace Plugins\Activity\App\Http\Controllers\Factory;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Factory\BaseController;

use Plugins\Activity\App\ActivityType;
use Addons\Core\Controllers\AdminTrait;

class ActivityTypeController extends BaseController
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function data(Request $request)
	{
		$activity_type = new ActivityType;
		$builder = $activity_type->newQuery()->orderBy('id','asc');
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}
}

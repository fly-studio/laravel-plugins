<?php
return [
    'activity' => [
        'store' => [
            'fid' => [
                'name' => '厂商ID',
                'rules' => 'required|not_zero|numeric',
            ],
            'type_id' => [
                'name' => '活动类型',
                'rules' => 'numeric',
            ],
            'name' => [
                'name' => '活动标题',
                'rules' => [],
            ],
            'aid' => [
                'name' => '活动封面',
                'rules' => 'required|numeric',
            ],
            'argc'=> [
                'name' => '参数',
                'rules' => []
            ],
            'start_date' => [
                'name' => '开始时间',
                'rules' => 'required|date',
            ],
            'end_date' => [
                'name' => '结束时间',
                'rules' => 'required|date',
            ],
            'order' => [
                'name' => '排序',
                'rules' => 'required|numeric',
            ],
        ],
    ],
    'activity_type' => [
        'store' => [
            'name' => [
                'name' => '类型名',
                'rules' => 'required',
            ],
            'class_dir' => [
                'name' => '类名',
                'rules' => 'required',
            ],
        ],
    ],
];
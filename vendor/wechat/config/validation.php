<?php
return [
	'wechat-account' => [
		'store' => [
			'name' => [
				'name' => '微信名称',
				'rules' => 'required|unique:wechat_accounts,{{attribute}},{{id}}',
			],
			'description' => [
				'name' => '简介',
				'rules' => [],
			],
			'wechat_type' => [
				'name' => '类型',
				'rules' => 'required|not_zero|field',
			],
			'appid' => [
				'name' => 'APP ID',
				'rules' => 'required|min:10|unique:wechat_accounts,{{attribute}},{{id}}',
			],
			'account' => [
				'name' => '原始 ID',
				'rules' => 'required|min:10|unique:wechat_accounts,{{attribute}},{{id}}',
			],
			'appsecret' => [
				'name' => 'APP Secrect',
				'rules' => 'required|min:10',
			],
			'token' => [
				'name' => 'Token',
				'rules' => 'required|min:1',
			],
			'avatar_aid' => [
				'name' => '二维码',
				'rules' => 'numeric',
			],
			'encodingaeskey' => [
				'name' => '加密KEY',
				'rules' => 'min:10',
			],
			'mchid' => [
				'name' => '商戶ID',
				'rules' => 'min:1',
			],
			'mchkey' => [
				'name' => '商户支付密钥',
				'rules' => 'min:1',
			],
			'sub_mch_id' => [
				'name' => '子商户号',
				'rules' => 'min:1',
			],

		],
	],
	'wechat-message' => [
		'store' => [
			'content' => [
				'name' => '内容',
				'rules' => 'required|max:600|min:1',
			],
			'type' => [
				'name' => '类型',
				'rules' => 'required|not_zero|field_name:wechat_message_type',
			],
		],
	],
	'wechat-reply' => [
		'store' => [
			'keywords' => [
				'name' => '关键词',
				'rules' => 'required_unless:match_type,subscribe|max:600|min:1',
				'message' => [
					'required_unless' => '必须输入关键词'
				],
			],
			'match_type' => [
				'name' => '匹配类型',
				'rules' => 'required|in:part,whole,subscribe',
			],
			'reply_count' => [
				'name' => '回复数量',
				'rules' => 'required|numeric',
			],
			'wdid' => [
				'name' => '素材库',
				'rules' => 'required|array',
			],
		],
	],
	'wechat-user' => [
		'store' => [
			'openid' => [
				'name' => 'OPEN ID',
				'rules' => 'required|min:6',
			],
			'nickname' => [
				'name' => '昵称',
				'rules' => 'min:1',
			],
			'gender' => [
				'name' => '性别',
				'rules' => 'field',
			],
			'avatar_aid' => [
				'name' => '头像(AID)',
				'rules' => 'numeric',
			],
			'country' => [
				'name' => '国家',
				'rules' => [],
			],
			'province' => [
				'name' => '省份',
				'rules' => [],
			],
			'city' => [
				'name' => '城市',
				'rules' => [],
			],
			'language' => [
				'name' => '语言',
				'rules' => [],
			],
			'unionid' => [
				'name' => '唯一ID',
				'rules' => [],
			],
			'remark' => [
				'name' => '备注名',
				'rules' => [],
			],
			'groupid' => [
				'name' => '组ID',
				'rules' => [],
			],
			'is_subscribed' => [
				'name' => '已关注',
				'rules' => 'boolean',
			],
			'subscribed_at' => [
				'name' => '关注时间',
				'rules' => 'date',
			],
			'uid' => [
				'name' => 'UID',
				'rules' => [],
			],
		],
	],
	'wechat-news' => [
		'store' => [
			'title' => [
				'name' => '标题',
				'rules' => 'required|min:1|max:62',
			],
			'author' => [
				'name' => '作者',
				'rules' => 'max:50',
			],
			'description' => [
				'name' => '摘要',
				'rules' => 'max:250',
			],
			'cover_aid' => [
				'name' => '封面(AID)',
				'rules' => 'required|numeric|not_zero',
			],
			'cover_in_content' => [
				'name' => '封面显示在正文中',
				'rules' => 'boolean',
			],
			'content' => [
				'name' => '正文',
				'rules' => [],
			],
			'url' => [
				'name' => '原文网址',
				'rules' => 'required_if:redirect,1|url|max:250',
				'message' => ['required_if' => '请输入原文网址，以便跳转。']
			],
			'redirect' => [
				'name' => '直接跳转',
				'rules' => 'boolean',
			],
		],
	],
	'wechat-depot' => [
		'store' => [
			'type' => [
				'name' => '类型',
				'rules' => 'required|field_name:wechat_message_type',
			],
			'wdnid' => [
				'name' => '文章ID',
				'rules' => 'required|array|min:1',
			],
			'title' => [ // 音乐/视频/图片/录音
				'name' => '内容',
				'rules' => 'required|max:250',
			],
			'size' => [
				'name' => '文件大小',
				'rules' => 'required_with:aid|numeric|not_zero',
			],
			'aid' => [
				'name' => '媒体文件(AID)',
				'rules' => 'required|numeric|not_zero',
			],
			'thumb_aid' => [
				'name' => '缩略图文件(AID)',
				'rules' => 'numeric',
			],
			'content' => [ // 文本
				'name' => '内容',
				'rules' => 'required|min:1',
			],
			'callback' => [ // 回调
				'name' => '编程内容',
				'rules' => 'required|min:1',
			],
			'description' => [
				'name' => '简介',
				'rules' => [],
			],
			'format' => [
				'name' => '格式',
				'rules' => 'required_with:aid',
			],
		],
	],
	'wechat-menu' => [
		'store' => [
			'title' => [
				'name' => '菜单名',
				'rules' => 'required|ansi:2|regex:/^[a-z\x{4e00}-\x{9fa5}\x{f900}-\x{fa2d}\s]*$/iu|max:50|min:1',
				'message' => ['regex' => '菜单必须为汉字、英文'],
			],
			'pid' => [
				'name' => '父菜单',
				'rules' => 'required|numeric',
			],
			'type' => [
				'name' => '类型',
				'rules' => 'required|in:view,click,event',
			],
			'event' => [
				'name' => '事件',
				'rules' => 'required_if:type,event|in:pic_sysphoto,pic_photo_or_album,pic_weixin,location_select,scancode_waitmsg,scancode_push',
				'message' => ['required_if' => '请选择具体的事件。']
			],
			'url' => [
				'name' => '链接',
				'rules' => 'required_if:type,view|url',
				'message' => ['required_if' => '请输入跳转网址。']
			],
			'wdid' => [
				'name' => '素材ID',
				'rules' => 'required_if:type,click|numeric',
				'message' => ['required_if' => '请选择素材。']
			],
			'content' => [
				'name' => 'JSON内容',
				'rules' => 'required|string|min:20',
			],
		 ],
	],
];
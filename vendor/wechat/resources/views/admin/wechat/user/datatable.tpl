<{extends file="admin/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>微信用户<{/block}>

<{block "name"}>wechat/user<{/block}>

<{block "head-scripts-after"}>
<script src="<{'js/emojione.js'|static}>"></script>
<script src="<{'js/wechat/choose.min.js'|plugins}>"></script>
<{/block}>

<{block "filter"}>
<{include file="[wechat]admin/wechat/user/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th class="text-center"><i class="gi gi-user"></i></th>
<th>OPEN ID</th>
<th>唯一ID</th>
<th>昵称</th>
<th>备注</th>
<th>性别</th>
<th>关注</th>
<th>国家</th>
<th>省份</th>
<th>城市</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': "avatar_aid", orderable: false, 'render': function(data, type, full){
		return '<img src="<{'attachment/resize'|url}>?id='+data+'&width=80&height=80" alt="avatar" class="img-responsive">';
	}},
	{'data': 'openid', orderable: false, 'render': function(data, type, full){
		return '<a href="<{'admin/wechat/user'|url}>/'+full['id']+'">' + data + '</a>';
	}},
	{'data': 'unionid'},
	{'data': 'nickname', 'render': function(data, type, full){
		return data ? '<span class="enable-emoji">'+ data.emojione() +'</span>' : '';
	}},
	{'data': 'remark'},
	{'data': '_gender', orderable: false, 'render': function(data, type, full){
		return '<span class="label label-primary">'+(data ? data.title : '未知')+'</span>';
	}},
	{'data': 'subscribed_at', 'render': function(data, type, full){
		return full['is_subscribed'] ? data : '<span class="label label-info">未关注</span>';
	}},
	{'data': 'country', orderable: false},
	{'data': 'province', orderable: false},
	{'data': 'city', orderable: false}
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个微信：'+full['openid']+'吗？';<{/block}>

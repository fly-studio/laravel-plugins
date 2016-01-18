<{extends file="factory-backend/extends/datatable.block.tpl"}>
<!-- 
公共Block 
由于extends中无法使用if/include，所以需要将公共Block均写入list.tpl、datatable.tpl
-->

<{block "title"}>活动<{/block}>

<{block "name"}>activity<{/block}>

<{block "filter"}>
<{include file="factory-backend/activity/filters.inc.tpl"}>
<{/block}>

<{block "table-th-plus"}>
<th>封面</th>
<th>标题</th>
<th>活动类型</th>
<th>起始时间</th>
<th>终止时间</th>
<th>状态</th>
<{/block}>

<!-- DataTable的Block -->

<{block "datatable-config-pageLength"}><{$_pagesize}><{/block}>

<{block "datatable-columns-plus"}>
var columns_plus = [
	{'data': 'aid', orderable: false, render: function(data){
		return data? '<img src="<{'attachment/resize'|url}>?id='+data+'&width=80&height=80" alt="" class="img-rounded">' : '';
	}},
	{'data': 'name'},
	{'data': 'activity_type',render:function(data){return data?data.name:'无';}},
	{'data': 'start_date'},
	{'data': 'end_date'},
	{'data': 'status',render:function(data, type, full){
	    var status_tag = '';
	    switch(parseInt(data)){
	        case 0 : status_tag='<a href="<{'factory/activity/setShelves'|url}>/'+full['id']+'/1" title="上架">未上架</a>';break;
	        case 1 :status_tag='<a href="<{'factory/activity/setShelves'|url}>/'+full['id']+'/-1" title="下架">上架中</a>'; break;
	        case -1 :status_tag='<a href="<{'factory/activity/setShelves'|url}>/'+full['id']+'/1" title="上架">下架</a>'; break;
	        default: status_tag='未知';
	   		}
	   		return status_tag;
		}
	}
];
<{/block}>
<{block "datatable-columns-options-plus"}>
var columns_options_plus = [
	'<a href="<{'factory/product?'|url}>base=&filters[activity_type][in][]='+full['id']+'" data-toggle="tooltip" title="商品列表" class="btn btn-xs btn-info"><i class="fa fa-photo"></i></a>'
];
<{/block}>
<{block "datatable-columns-options-delete-confirm"}>var columns_options_delete_confirm = '您确定删除这个活动：'+full['name']+'吗？';<{/block}>

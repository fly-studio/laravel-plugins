<{if $_permissionTable->checkUserRole('super')}>
<li>
	<a href="#" class="sidebar-nav-menu"><i class="fa fa-angle-left sidebar-nav-indicator"></i><i class="fa fa-slack sidebar-nav-icon"></i>OAuth2管理</a>
	<ul>
		<li><a href="<{'admin/oauth/client'|url}>" name="oauth/client/list" class="col-md-8">客户端管理</a><a href="<{'admin/oauth/client/create'|url}>" name="oauth/client/create" class="col-md-4"><i class="glyphicon glyphicon-plus"></i> 添加</a><div class="clearfix"></div></li>
	</ul>
</li>
<{/if}>

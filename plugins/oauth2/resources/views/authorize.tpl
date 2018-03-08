<{extends file="extends/main.block.tpl"}>

<{block "body-container"}>
<div class="container">

    <h1 class="page-header">请求授权</h1>
    <p>该应用由 <strong><{$client->name }></strong> 开发，向其提供以下权限即可继续操作。</p>
    <{if !empty($scopes)}>
    <div class="row">
        <div class="col-xs-12">
            <p><strong>该应用将会获得：</strong></p>
            <ul>
                <{foreach $scopes as $scope}>
                <li><input type="checkbox" checked="checked" disabled="disabled" ><{ $scope->description }></li>
                <{/foreach}>
            </ul>
        </div>
    </div>
    <{/if}>
    <div class="row" style="margin-top: 50px;">
        <div class="col-xs-12 text-center">
            <form method="post" action="<{'api/oauth/authorize'|url}>">
                <{csrf_field() nofilter}>

                <input type="hidden" name="state" value="<{ $request->state }>">
                <input type="hidden" name="client_id" value="<{ $client->id }>">
                <button type="submit" class="btn btn-success btn-approve  btn-block"><i class="glyphicon glyphicon-ok"></i> 确认登录</button>
            </form>
        </div>
        <div class="col-xs-12 text-center hidden">
            <form method="post" action="<{'api/oauth/authorize'|url}>">
                <{csrf_field() nofilter}>
                <{method_field('DELETE') nofilter}>

                <input type="hidden" name="state" value="<{ $request->state }>">
                <input type="hidden" name="client_id" value="<{ $client->id }>">
                <button class="btn btn-danger btn-link">拒绝</button>
            </form>
        </div>

    </div>
</div>
<{/block}>

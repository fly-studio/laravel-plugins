(function($){
	$().ready(function(){
		var $options = $('.block-options:eq(0)', '#page-content');
		$('<b>當前公眾號：</b><a href="'+$.baseuri+'wechat/choose?url='+encodeURIComponent(window.location.href)+'" class="btn btn-sm btn-default enable-tooltip" id="modifing-account" title="" data-original-title="切換微信公眾號"><i class="fa fa-wechat"></i> 切換公眾號</a>').prependTo($options).tooltip();
		LP.get(LP.baseuri + 'wechat/modifing-account').done(function(json){
			$('#modifing-account').html( '<i class="fa fa-wechat text-success">&nbsp;</i> ' + json.data.name.toHTML());
		});
	});
})(jQuery);